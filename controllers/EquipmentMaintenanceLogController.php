<?php

namespace app\controllers;

use app\jobs\EquipmentMaintenanceLogCreateDataSender;
use app\models\EquipmentMaintenanceLog;
use app\models\EquipmentMaintenanceLogSearch;
use app\models\FicEquipment;
use app\models\MaintenanceLogComponentPart;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class EquipmentMaintenanceLogController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new EquipmentMaintenanceLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMaintenanceList()
    {
        $request = Yii::$app->request;
        $searchModel = new EquipmentMaintenanceLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fic_equipment_id = $request->getQueryParam('fic_equipment_id');

        if ($fic_equipment_id != null)
            $dataProvider->query->filterWhere(['fic_equipment_id' => $fic_equipment_id]);

        return $this->render('maintenance-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ficEquipment' => $this->findFicEquipment($fic_equipment_id),
        ]);
    }

    public function actionMaintain($id)
    {
        $ficEquipment = $this->findFicEquipment($id);
        $equipmentComponents = $ficEquipment->equipment->equipmentComponents;
        $maintenanceLogModel = new EquipmentMaintenanceLog();
        $logComponentParts = [];

        if ($this->request->isPost) {
            if ($maintenanceLogModel->load($this->request->post())) {
                $valid = $maintenanceLogModel->validate();

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$flag = $maintenanceLogModel->save(false)) {
                        $transaction->rollBack();
                        return;
                    }

                    if (isset($_POST['MaintenanceLogComponentPart'][0][0])) {
                        foreach ($_POST['MaintenanceLogComponentPart'] as $i => $logComponentParts) {
                            foreach ($logComponentParts as $partLog) {
                                $data['MaintenanceLogComponentPart'] = $partLog;
                                $logPart = new MaintenanceLogComponentPart();
                                $logPart->load($data);
                                $logPart->equipment_maintenance_log_id = $maintenanceLogModel->id;

                                $valid = $logPart->validate() && $valid;
                                if (!$flag = $logPart->save(false)) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->queue->push(new EquipmentMaintenanceLogCreateDataSender([
                            'url' => Yii::$app->params['apiBaseUrl2'] . '/equipment-maintenance-log',
                            'equipmentMaintenanceLogId' => $maintenanceLogModel->id,
                        ]));
                        return $this->redirect([
                            'maintenance-list', 'fic_equipment_id' => $ficEquipment->id
                        ]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }



        $maintenanceLogModel->fic_equipment_id = $id;

        foreach ($equipmentComponents as $iec => $equipmentComponent) {
            foreach ($equipmentComponent->equipmentComponentParts as $iecp => $equipmentComponentPart) {
                $logPart = new MaintenanceLogComponentPart();
                $logPart->isOperational = MaintenanceLogComponentPart::IS_OPERATIONAL_YES;
                $logPart->isInspected = MaintenanceLogComponentPart::IS_INSPECTED_YES;
                $logPart->equipment_component_part_id = $equipmentComponentPart->id;
                $logPart->equipment_component_id = $equipmentComponentPart->equipmentComponent->id;
                $logComponentParts[$iec][$iecp] = $logPart;
            }
        }

        return $this->render('maintain', [
            'ficEquipment' => $ficEquipment,
            'equipmentComponents' => $equipmentComponents,
            'maintenanceLogModel' => $maintenanceLogModel,
            'logComponentParts' => $logComponentParts
        ]);
    }

    public function actionLogDetails()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = EquipmentMaintenanceLog::findOne($_POST['expandRowKey']);
            return $this->renderPartial('_expand-row-details', ['model' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }
    public function actionView($id)
    {
        $maintainanceLog = $this->findEquipmentMaintananceLog($id);
        $groupedParts = ArrayHelper::index($maintainanceLog->maintenanceLogComponentParts, null, function ($el) {
            return $el['equipment_component_id'];
        });
        return $this->render('view', [
            'maintainanceLog' => $maintainanceLog,
            'groupedParts' => $groupedParts,
        ]);
    }

    protected function findFicEquipment($id)
    {
        if (($model = FicEquipment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findEquipmentMaintananceLog($id)
    {
        if (($model = EquipmentMaintenanceLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
