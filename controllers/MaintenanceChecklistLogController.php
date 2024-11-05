<?php

namespace app\controllers;

use app\jobs\MaintenanceChecklistLogCreateDataSender;
use app\models\ChecklistCriteria;
use app\models\FicEquipment;
use app\models\MaintenanceChecklistLog;
use app\models\MaintenanceChecklistLogSearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use linslin\yii2\curl;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * MaintenanceChecklistLogController implements the CRUD actions for MaintenanceChecklistLog model.
 */
class MaintenanceChecklistLogController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all MaintenanceChecklistLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MaintenanceChecklistLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaintenanceChecklistLog model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // $checklistLog = $this->findChecklistLog($id);
        $checklistLog = $this->findModel($id);
        $indexedCriterias = ArrayHelper::index($checklistLog->checklistCriterias, null, 'component_name');
        $ficEquipment = $this->findFicEquipment($checklistLog->ficEquipment->id);

        return $this->render('view', [
            // 'checklistLog' => $checklistLog,
            'checklistLog' => $checklistLog,
            'indexedCriterias' => $indexedCriterias,
            'ficEquipment' => $ficEquipment
        ]);
    }

    public function actionFicEquipment($id)
    {
        $searchModel = new MaintenanceChecklistLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $ficEquipment = $this->findFicEquipment($id);
        // $ficEquipment->maintenanceChecklistLogs;
        return $this->render('fic-equipment', [
            'ficEquipment' => $ficEquipment,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionChecklist($id)
    {
        $ficEquipment = $this->findFicEquipment($id);
        $checklistLog = new MaintenanceChecklistLog();
        $checklistComponentTemplates = $ficEquipment->getChecklistComponentTemplates()->with(['criteriaTemplates', 'component',])->all();
        $checklistCriterias = [];

        if ($this->request->isPost) {
            if ($checklistLog->load($this->request->post())) {
                $url = Yii::$app->params['apiBaseUrl'] . '/maintenance-checklist-log';
                $transaction = Yii::$app->db->beginTransaction();

                try {
                    $valid = $checklistLog->validate();
                    if (!$valid)
                        return;

                    if ($flag = $checklistLog->save(false)) {
                        if (isset($_POST['ChecklistCriteria'][0][0])) {
                            foreach ($_POST['ChecklistCriteria'] as $i => $components) {
                                foreach ($components as $criteria) {
                                    $data['ChecklistCriteria'] = $criteria;
                                    $checklistCriteria = new ChecklistCriteria();
                                    $checklistCriteria->load($data);

                                    $checklistCriteria->link('maintenanceChecklistLog', $checklistLog);
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->queue->push(new MaintenanceChecklistLogCreateDataSender([
                            'maintenanceChecklistLogId' => $checklistLog->id,
                            'ficEquipmentId' => $ficEquipment->id,
                            // 'ficEquipmentGId' => $ficEquipment->global_id,
                            'url' => $url,
                        ]));

                        return $this->redirect([
                            'fic-equipment', 'id' => $ficEquipment->id
                        ]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        foreach ($checklistComponentTemplates as $i => $component) {
            foreach ($component->criteriaTemplates as $j => $criteria) {
                $checklistCriteria = new ChecklistCriteria();
                $checklistCriteria->equipment_component_id = $component->equipment_component_id;
                $checklistCriteria->component_name = isset($component->component) ? $component->component->name : "Other components";
                $checklistCriteria->criteria = $criteria->description;
                $checklistCriteria->result = ChecklistCriteria::RESULT_YES;

                $checklistCriterias[$i][$j] = $checklistCriteria;
            }
        }

        return $this->render('checklist', [
            'ficEquipment' => $ficEquipment,
            'checklistLog' => $checklistLog,
            'checklistComponentTemplates' => $checklistComponentTemplates,
            'checklistCriterias' => $checklistCriterias,
        ]);
    }

    public function actionPdfExport($id)
    {
        $checklistLog = $this->findModel($id);
        $indexedCriterias = ArrayHelper::index($checklistLog->checklistCriterias, null, 'component_name');
        $fic = $checklistLog->getFic()->with(['region'])->one();
        $ficEquipment = $checklistLog->getFicEquipment()->with(['equipment'])->one();

        $pdf = Yii::$app->pdf;
        $pdf->cssInline = $this->renderPartial('pdf/inline.css');
        $pdf->content = $this->renderPartial('pdf/_checklist', [
            'checklistLog' => $checklistLog,
            'fic' => $fic,
            'ficEquipment' => $ficEquipment,
            'indexedCriterias' => $indexedCriterias,
        ]);

        return $pdf->render();
    }

    /**
     * Creates a new MaintenanceChecklistLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MaintenanceChecklistLog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MaintenanceChecklistLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdateChecklist($id)
    {

        $checklistLog = $this->findModel($id);
        $ficEquipment = $this->findFicEquipment($checklistLog->ficEquipment->id);
        $checklistCriterias = $checklistLog->checklistCriterias;



        if ($this->request->isPost && $checklistLog->load($this->request->post())) {
            $flag = $checklistLog->save(false);
            if ($flag) {
                if (isset($_POST['ChecklistCriteria'])) {
                    foreach ($_POST['ChecklistCriteria'] as $i => $components) {
                        foreach ($components as $j => $criteria) {
                            $data['ChecklistCriteria'] = $criteria;
                            $checklistCriteria = ChecklistCriteria::findOne($criteria['id']);
                            $checklistCriteria->load($data);
                            $checklistCriteria->validate();
                            $checklistCriteria->save();
                        }
                    }

                    return $this->redirect(['view', 'id' => $checklistLog->id]);
                }
            }
        }

        // if ($this->request->isPost) {
        //     $transaction = Yii::$app->db->beginTransaction();
        //     $flag = $checklistLog->save(false);
        //     if ($flag) {
        //         if (isset($_POST['ChecklistCriteria'])) {
        //             foreach ($_POST['ChecklistCriteria'] as $i => $components) {
        //                 foreach ($components as $criteria) {
        //                     $data['ChecklistCriteria'] = $criteria;
        //                     $checklistCriteria = new ChecklistCriteria();
        //                     $checklistCriteria->load($data);

        //                     $checklistCriteria->link('maintenanceChecklistLog', $checklistLog);
        //                 }
        //             }
        //         }
        //     }

        //     if ($flag) {
        //         $transaction->commit();
        //     } else {
        //         $transaction->rollBack();
        //     }
        // }
        return $this->render('_update-checklist', [
            'checklistLog' => $checklistLog,
            'checklistCriterias' => $checklistCriterias,


        ]);
    }

    /**
     * Deletes an existing MaintenanceChecklistLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MaintenanceChecklistLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MaintenanceChecklistLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaintenanceChecklistLog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // protected function findChecklistLog($id)
    // {
    //     if (($list = MaintenanceChecklistLog::findOne($id)) !== null) {
    //         return $list;
    //     }

    //     throw new NotFoundHttpException('The requested page does not exist.');
    // }

    protected function findFicEquipment($id)
    {
        if (($model = FicEquipment::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
