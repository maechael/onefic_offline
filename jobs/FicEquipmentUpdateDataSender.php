<?php

namespace app\jobs;

use app\models\FicEquipment;
use Codeception\Util\HttpCode;
use linslin\yii2\curl;
use Yii;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * Class FicEquipmentUpdateDataSender.
 */
class FicEquipmentUpdateDataSender extends \yii\base\BaseObject implements \yii\queue\RetryableJobInterface
{
    public $ficEquipmentId;
    public $url;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        try {
            $model = FicEquipment::findOne($this->ficEquipmentId);
            $this->sendData($model);
        } catch (\Exception $e) {
            Yii::error('FIC Equipment Update Sync Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendData($model)
    {
        $curl = new curl\Curl();
        $response = $curl->setRequestBody(Json::encode($model))
            ->setHeaders(['Content-Type' => 'application/json'])
            ->put($this->url);

        if ($curl->responseCode !== HttpCode::OK) {
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
