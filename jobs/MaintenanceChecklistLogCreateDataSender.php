<?php

namespace app\jobs;

use app\models\FicEquipment;
use app\models\MaintenanceChecklistLog;
use Codeception\Util\HttpCode;
use Yii;
use yii\helpers\Json;
use linslin\yii2\curl;

/**
 * Class MaintenanceChecklistLogCreateDataSender.
 */
class MaintenanceChecklistLogCreateDataSender extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $maintenanceChecklistLogId;
    public $ficEquipmentId;
    // public $ficEquipmentGId;
    public $url;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            $criteriaResults = [];
            $model = MaintenanceChecklistLog::findOne($this->maintenanceChecklistLogId);
            $ficEquipment = FicEquipment::findOne($this->ficEquipmentId);
            $checklistCriterias = $model->checklistCriterias;

            if (count($checklistCriterias) > 0) {
                foreach ($checklistCriterias as $i => $checklistCriteria) {
                    $criteriaResults[] = [
                        "equipment_component_id" => $checklistCriteria->equipment_component_id,
                        "component_name" => $checklistCriteria->component_name,
                        "criteria" => $checklistCriteria->criteria,
                        "result" => $checklistCriteria->result,
                        "remarks" => $checklistCriteria->remarks
                    ];
                }
            }

            $params = [
                "fic_equipment_gid" => $ficEquipment->global_id,
                "accomplished_by_name" => $model->accomplished_by_name,
                "accomplished_by_designation" => $model->accomplished_by_designation,
                "accomplished_by_office" => $model->accomplished_by_office,
                "accomplished_by_date" => $model->accomplished_by_date,
                "endorsed_by_name" => $model->endorsed_by_name,
                "endorsed_by_designation" => $model->endorsed_by_designation,
                "endorsed_by_office" => $model->endorsed_by_office,
                "endorsed_by_date" => $model->endorsed_by_date,
                "criteriaResults" => $criteriaResults
            ];

            $response = $this->sendData($params);

            $data = Json::decode($response);
            if (!isset($data['global_id'])) {
                throw new \Exception('Unexpected API response: ' . $response);
            }

            $model->global_id = $data['global_id'];
            if (!$model->save()) {
                throw new \Exception('Failed to save model to database');
            }
        } catch (\Exception $e) {
            Yii::error('Maintenance Checklist Log Creation Sync Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendData($params)
    {
        $curl = new curl\Curl();
        $response = $curl->setRequestBody(Json::encode($params))
            ->setHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($this->url);

        if ($curl->responseCode !== HttpCode::CREATED) {
            throw new \Exception('API call failed with status code ' . $curl->responseCode);
        }

        return $response;
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60 * 3;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 5;
    }
}
