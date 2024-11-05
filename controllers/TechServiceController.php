<?php

namespace app\controllers;

use app\models\TechService;
use Yii;
use yii\web\Response;

class TechServiceController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetTechService()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $techServices = TechService::find()->joinWith('equipmentTechServices')->where(['{{%equipment_tech_service}}.equipment_id' => $id])->all();
            $selected = null;

            if ($id != null && count($techServices) > 0) {
                $selected = '';
                foreach ($techServices as $i => $techService) {
                    $out[] = ['id' => $techService['id'], 'name' => $techService['name']];

                    // if ($i == 0) {
                    //     $selected = $techService['id'];
                    // }
                }


                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
}
