<?php

namespace app\jobs;

use app\models\EquipmentIssue;
use app\models\EquipmentIssueRepair;
use Codeception\Util\HttpCode;
use Exception;
use linslin\yii2\curl;
use Yii;
use yii\helpers\Json;

/**
 * Class IssueRepairCreateDataSender.
 */
class IssueRepairCreateDataSender extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $equipmentIssueId;
    public $issueRepairId;
    public $url;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            $equipmentIssue = EquipmentIssue::findOne($this->equipmentIssueId);
            $issueRepair = EquipmentIssueRepair::findOne($this->issueRepairId);

            $params = [
                'equipment_issue_gid' => $equipmentIssue->global_id,
                'performed_by' => $issueRepair->performed_by,
                'issue_status' => $issueRepair->issue_status,
                'repair_activity' => $issueRepair->repair_activity,
                'remarks' => $issueRepair->remarks,
            ];

            $response = $this->sendData($params);

            $data = Json::decode($response);
            if (!isset($data['global_id'])) {
                throw new \Exception('Unexpected API response: ' . $response);
            }

            $issueRepair->global_id = $data['global_id'];
            if (!$issueRepair->save()) {
                throw new \Exception('Failed to save model to database');
            }
        } catch (Exception $e) {
            Yii::error('Equipment Issue Repair Sync Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendData($params)
    {
        $curl = new curl\Curl();
        $response = $curl->setRequestBody(Json::encode($params))
            ->setHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->url);

        // ->post("{$url}/equipment-issue-repair");

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
