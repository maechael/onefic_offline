<?php

namespace app\jobs;

use app\models\FicEquipment;
use Codeception\Util\HttpCode;
use linslin\yii2\curl;
use Yii;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * Class FicEquipmentCreateDataSender.
 */
class FicEquipmentCreateDataSender extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $url;
    public $ficEquipmentId;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            $model = FicEquipment::findOne($this->ficEquipmentId);
            $response = $this->sendData($model);

            $data = Json::decode($response);
            if (!isset($data['global_id'])) {
                throw new \Exception('Unexpected API response: ' . $response);
            }

            $model->global_id = $data['global_id'];
            if (!$model->save()) {
                throw new \Exception('Failed to save model to database');
            }
        } catch (\Exception $e) {
            Yii::error('FIC Equipment Creation Sync Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendData($model)
    {
        $curl = new curl\Curl();
        $response = $curl->setRequestBody(Json::encode($model))
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
