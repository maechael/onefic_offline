<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use linslin\yii2\curl;
use yii\helpers\Json;

class ApiTestController extends Controller
{
    public function actionTestUpload()
    {
        if (Yii::$app->request->isPost) {
            $test = Yii::$app->request->headers;
            $curl = new curl\Curl();
            $url = Yii::$app->params['testApiBaseUrl'];
            $images = UploadedFile::getInstancesByName('equipmentIssueImages');

            $headers = [
                'Content-Type' => $test['content-type'],
                'Accept-Encoding' => 'gzip,deflate',
                'Accept' => "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
                'Cache-Control' => "max-age=0",
                // 'Content-Length' => $test['content-length'],
                // 'Cookie' => $test['cookie'],
                'Connection' => 'keep-alive'
            ];

            $params = [
                'test' => 'tickles',
            ];
            foreach ($images as $i => $img) {
                $params["equipmentIssueImages[$i]"] =  new \CURLFile($img->tempName, $img->type, $img->name);
            }

            // $params = [
            //     'testPost' => 'testValue',
            //     'test' => $images
            // ];

            // $response = $curl->setPostParams($params)
            //     ->setHeaders($headers)
            //     ->post("{$url}/media/upload");

            $response = $curl->setOption(
                CURLOPT_POSTFIELDS,
                $params
            )->post("{$url}/media/upload");

            $code = $curl->responseCode;
        }
        return $this->render('test-upload');
    }
}
