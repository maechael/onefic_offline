<?php

namespace app\jobs;

use app\models\EquipmentIssue;
use Codeception\Util\HttpCode;
use linslin\yii2\curl;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * Class EquipmentIssueCreateDataSender.
 */
class EquipmentIssueCreateDataSender extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $url;
    public $equipmentIssueId;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            $model = EquipmentIssue::findOne($this->equipmentIssueId);
            $params = [
                'fic_equipment_gid' => $model->fic_equipment_gid,
                'title' => $model->title,
                'description' => $model->description,
                'reported_by' => $model->reported_by,
                'relatedPartIds' => Json::encode(ArrayHelper::getColumn($model->issueRelatedParts, 'component_part_id')),
                'relatedComponentIds' => Json::encode(ArrayHelper::getColumn($model->issueRelatedComponents, 'component_part_id')),
            ];

            foreach ($model->localMedias as $i => $img) {
                $file = new UploadedFile([
                    'name' => $img->filename,
                    // 'tempName' => '@app' . "/{$img->filepath}",
                    'tempName' => Url::to('@app/web/') . $img->filepath,
                    'type' => $img->type,
                    'size' => $img->size,
                    'error' => 0
                ]);
                $params["equipmentIssueImgs[$i]"] =  new \CURLFile($file->tempName, $file->type, $file->name);
            }

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
            Yii::error('Equipment Issue Creation Sync Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendData($params)
    {
        $curl = new curl\Curl();
        $response = $curl->setOption(CURLOPT_POSTFIELDS, $params)->post($this->url);

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
