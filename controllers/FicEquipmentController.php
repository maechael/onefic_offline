<?php

namespace app\controllers;

use app\jobs\EquipmentIssueCreateDataSender;
use app\jobs\FicEquipmentCreateDataSender;
use app\jobs\FicEquipmentUpdateDataSender;
use app\jobs\IssueRepairCreateDataSender;
use app\models\Equipment;
use app\models\EquipmentIssue;
use app\models\EquipmentIssueImage;
use app\models\EquipmentIssueRepair;
use app\models\EquipmentIssueSearch;
use app\models\FicEquipment;
use app\models\FicEquipmentSearch;
use app\models\FicEquipmentStatusHistory;
use app\models\IssueRelatedPart;
use app\models\LocalMedia;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use linslin\yii2\curl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * FicEquipmentController implements the CRUD actions for FicEquipment model.
 */
class FicEquipmentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'issues' => ['POST', 'GET']
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'update-status', 'delete', 'issues', 'issue', 'create-issue', 'create-repair',],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all FicEquipment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FicEquipmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fic' => Yii::$app->user->identity->userProfile->fic,
            'ficEquipment' => new FicEquipment(),
            'equipments' => Equipment::getEquipments()
        ]);
    }

    /**
     * Displays a single FicEquipment model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FicEquipment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FicEquipment();

        if (Yii::$app->request->isAjax && $this->request->isPost) {
            if ($model->load($this->request->post())) {
                $url = Yii::$app->params['apiBaseUrl'] . '/fic-equipment';

                $model->fic_id = Yii::$app->user->identity->userProfile->fic_affiliation;

                if ($model->save()) {
                    Yii::$app->queue->push(new FicEquipmentCreateDataSender([
                        'url' => $url,
                        'ficEquipmentId' => $model->id
                    ]));

                    return $this->asJson(['success' => true]);
                }
            }

            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;    //..$errors is a fucking array of error messages
            }

            return $this->asJson(['validation' => $result]);
        }

        return $this->render('create', [
            'model' => $model,
            'equipments' => Equipment::getEquipments()
        ]);
    }

    /**
     * Updates an existing FicEquipment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'equipments' => Equipment::getEquipments()
        ]);
    }

    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isAjax && $this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $url = Yii::$app->params['apiBaseUrl'] . "/fic-equipment/{$model->global_id}";

                $statusHistory = new FicEquipmentStatusHistory();
                $statusHistory->fic_equipment_id = $model->id;
                $statusHistory->status = $model->status;
                $statusHistory->remarks = $model->remarks;
                $statusHistory->save();


                Yii::$app->queue->push(new FicEquipmentUpdateDataSender([
                    'url' => $url,
                    'ficEquipmentId' => $model->id,
                ]));
                return $this->asJson(['success' => true]);
            }

            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }
        return null;
    }

    /**
     * Deletes an existing FicEquipment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->softDelete();

        return $this->redirect(['index']);
    }

    public function actionIssues()
    {
        $request = Yii::$app->request;
        $searchModel = new EquipmentIssueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fic_equipment_id = $request->getQueryParam('fic_equipment_id');

        if ($fic_equipment_id != null) {
            $dataProvider->query->andFilterWhere(['fic_equipment_id' => $fic_equipment_id]);
        } else {
            $fic_equipment_id = $request->getQueryParam('EquipmentIssueSearch')['fic_equipment_id'];
        }

        // $fic_equipment_id = $fic_equipment_id != null ? $fic_equipment_id : $request->getQueryParam('EquipmentIssueSearch')['fic_equipment_id'];

        return $this->render('issues', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ficEquipment' => $this->findModel($fic_equipment_id)
        ]);
    }

    public function actionIssue($id)
    {
        $issue = $this->findIssue($id);
        $equipmentIssueRepair = new EquipmentIssueRepair();
        // $equipmentIssueRepair->equipment_issue_gid = $issue->global_id;

        return $this->render('issue', [
            'issue' => $issue,
            'equipmentIssueRepair' => $equipmentIssueRepair,
        ]);
    }

    public function actionCreateIssue()
    {
        $issue = new EquipmentIssue();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $url = Yii::$app->params['apiBaseUrl'] . '/equipment-issue';
            $flag = false;
            $result = [];

            if ($issue->load($this->request->post()) && $issue->save()) {
                $transaction = Yii::$app->db->beginTransaction();
                try {

                    $issue->equipmentIssueImgs = UploadedFile::getInstances($issue, 'equipmentIssueImgs');

                    if (!empty($issue->relatedPartIds)) {
                        foreach ($issue->relatedPartIds as $partId) {
                            $issueRelatedPart = new IssueRelatedPart();
                            $issueRelatedPart->equipment_issue_id = $issue->id;
                            $issueRelatedPart->component_part_id = $partId;
                            $issueRelatedPart->type = IssueRelatedPart::TYPE_PART;

                            if (!$flag = $issueRelatedPart->save())
                                break;
                        }
                    }

                    if (!empty($issue->relatedComponentIds)) {
                        foreach ($issue->relatedComponentIds as $componentId) {
                            $issueRelatedPart = new IssueRelatedPart();
                            $issueRelatedPart->equipment_issue_id = $issue->id;
                            $issueRelatedPart->component_part_id = $componentId;
                            $issueRelatedPart->type = IssueRelatedPart::TYPE_COMPONENT;

                            if (!$flag = $issueRelatedPart->save())
                                break;
                        }
                    }

                    if ($flag) {
                        foreach ($issue->equipmentIssueImgs as $image) {
                            $localMedia = new LocalMedia();
                            $localMedia->set($image, Yii::$app->params["equipment_issue_folder"]);

                            if ($flag = $flag && $localMedia->save()) {
                                $equipmentIssueImage = new EquipmentIssueImage();
                                $equipmentIssueImage->equipment_issue_id = $issue->id;
                                $equipmentIssueImage->local_media_id = $localMedia->id;

                                if ($flag = $flag && $equipmentIssueImage->save()) {
                                    $flag = $localMedia->upload($image);
                                } else {
                                    break;
                                }
                            } else {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();

                        Yii::$app->queue->push(new EquipmentIssueCreateDataSender([
                            'url' => $url,
                            'equipmentIssueId' => $issue->id,
                        ]));
                        return $this->asJson(['success' => true]);
                    } else {
                        $transaction->rollBack();
                        $result = [];

                        foreach ($issue->getErrors() as $attribute => $errors) {
                            $result[Html::getInputId($issue, $attribute)] = $errors;
                        }

                        return $this->asJson(['validation' => $result]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }


                return $this->asJson(['validation' => $result]);
            } else {
                $result = [];

                foreach ($issue->getErrors() as $attribute => $errors) {
                    $result[Html::getInputId($issue, $attribute)] = $errors;
                }

                return $this->asJson(['validation' => $result]);
            }
        }
        return null;
    }

    public function actionCreateRepair()
    {
        $issueRepair = new EquipmentIssueRepair();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if ($issueRepair->load($this->request->post())) {
                $url = Yii::$app->params['apiBaseUrl'] . '/equipment-issue-repair';
                $equipmentIssue = EquipmentIssue::findOne($issueRepair->equipment_issue_id);

                if ($equipmentIssue->status == EquipmentIssue::STATUS_CLOSED)
                    throw new ForbiddenHttpException("Equipment issue has already been closed.");

                $equipmentIssue->status = $issueRepair->issue_status;

                if ($issueRepair->save()) {
                    Yii::$app->queue->push(new IssueRepairCreateDataSender([
                        'equipmentIssueId' => $equipmentIssue->id,
                        'issueRepairId' => $issueRepair->id,
                        'url' => $url,
                    ]));

                    return $this->asJson(['success' => true]);
                }
            } else {
                foreach ($issueRepair->getErrors() as $attribute => $errors) {
                    $result[Html::getInputId($issueRepair, $attribute)] = $errors;
                }

                return $this->asJson(['validation' => $result]);
            }
        }
        return null;
    }

    /**
     * Finds the FicEquipment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FicEquipment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FicEquipment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findIssue($id)
    {
        if (($issue = EquipmentIssue::findOne($id)) !== null) {
            return $issue;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
