<?php

namespace app\controllers;

use app\models\Equipment;
use app\models\FicEquipment;
use app\models\FicTechService;
use app\models\FicTechServiceSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use linslin\yii2\curl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * FicTechServiceController implements the CRUD actions for FicTechService model.
 */
class FicTechServiceController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all FicTechService models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new FicTechServiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $equipments = Equipment::getEquipmentsByFicId(Yii::$app->user->identity->userProfile->fic->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'equipments' => $equipments

        ]);
    }

    /**
     * Displays a single FicTechService model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FicTechService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new FicTechService();
        $model->fic_id = Yii::$app->user->identity->userProfile->fic->id;
        $equipments = Equipment::getEquipmentsByFicId($model->fic_id);
        if (Yii::$app->request->isAjax) {

            if ($model->load($this->request->post())) {
                $curl = new curl\curl();
                $url = Yii::$app->params['apiBaseUrl'];

                $params = [
                    'fic_id' => $model->fic_id,
                    'equipment_id' => $model->equipment_id,
                    'tech_service_id' => $model->tech_service_id,
                    'charging_type' => $model->charging_type,
                    'charging_fee' => $model->charging_fee
                ];

                $response = $curl->setRequestBody(Json::encode($params))
                    ->setHeaders([
                        'Content-Type' => 'application/json',
                    ])
                    ->post("{$url}/fic-tech-service");


                switch ($curl->responseCode) {
                    case 'timeout':
                        //timeout error logic here
                        $flag = false;
                        break;
                    case 200:
                        $data = Json::decode($response);
                        $model->global_id = $data['global_id'];
                        $flag = $model->save(false);
                        break;
                    case 201:
                        $data = Json::decode($response);
                        $model->global_id = $data['global_id'];
                        $flag = $model->save(false);
                        break;
                    case 404:
                        //404 Error logic here
                        break;
                    case 422:   //..Unprocessable Entity
                        $dataErrors = ArrayHelper::index(Json::decode($response), null, 'field');
                        foreach ($dataErrors as $key => $errors) {
                            $result[Html::getInputId($model, $key)] = ArrayHelper::getColumn($errors, 'message');
                        }
                        break;
                }

                return $this->asJson(['success' => true]);
            } else {
                foreach ($model->getErrors() as $attribute => $errors) {
                    $result[Html::getInputId($model, $attribute)] = $errors;
                }

                return $this->asJson(['validation' => $result]);
            }

            $result = [];

            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }
        return null;
    }

    /**
     * Updates an existing FicTechService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $equipments = Equipment::getEquipmentsByFicId($model->fic_id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'equipments' => $equipments
        ]);
    }

    /**
     * Deletes an existing FicTechService model.
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
     * Finds the FicTechService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FicTechService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FicTechService::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
