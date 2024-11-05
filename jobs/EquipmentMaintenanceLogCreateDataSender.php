<?php

namespace app\jobs;

use app\models\EquipmentMaintenanceLog;
use Codeception\Util\HttpCode;
use Exception;
use linslin\yii2\curl;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Class EquipmentMaintenanceLogCreateDataSender.
 */
class EquipmentMaintenanceLogCreateDataSender extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $url;
    public $equipmentMaintenanceLogId;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            $maintenanceLog = EquipmentMaintenanceLog::findOne($this->equipmentMaintenanceLogId);
            $componentParts = $maintenanceLog->maintenanceLogComponentParts;

            $maintenanceLogComponentParts = [];

            foreach ($componentParts as $i => $componentPart) {
                $maintenanceLogComponentParts[] = [
                    "equipment_component_id" => $componentPart->equipment_component_id,
                    "equipment_component_part_id" => $componentPart->equipment_component_part_id,
                    "isInspected" => $componentPart->isInspected,
                    "isOperational" => $componentPart->isOperational,
                    "remarks" => $componentPart->remarks,
                ];
            }

            $params = [
                "fic_equipment_gid" => $maintenanceLog->ficEquipment->global_id,
                "maintenance_date" => $maintenanceLog->maintenance_date,
                "time_started" => $maintenanceLog->time_started,
                "time_ended" => $maintenanceLog->time_ended,
                "conclusion_recommendation" => $maintenanceLog->conclusion_recommendation,
                "inspected_checked_by" => $maintenanceLog->inspected_checked_by,
                "noted_by" => $maintenanceLog->noted_by,
                "maintenanceLogComponentParts" => $maintenanceLogComponentParts,
            ];

            $response = $this->sendData($params);
            $result = Json::decode($response);

            if ($result['status'] && !isset($result['data'])) {
                throw new \Exception('Unexpected API response: ' . $response);
            }

            $maintenanceLog->global_id = $result['data']['global_id'];
            if (!$maintenanceLog->save()) {
                throw new \Exception('Failed to save model to database');
            }
        } catch (Exception $e) {
            Yii::error('FIC Equipment Creation Sync Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendData($params)
    {
        $curl = new curl\Curl();

        $response = $curl->setRequestBody(Json::encode($params))
            ->setHeaders(['Content-Type' => 'application/json'])
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
