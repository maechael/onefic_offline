<?php

namespace app\controllers;

use app\jobs\TestJob;
use app\models\Fic;
use app\models\Region;
use Yii;
use yii\filters\AccessControl;

class FicController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index',],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index',],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        return $this->render('index', [
            'fic' => Yii::$app->user->identity->userProfile->fic
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        return $this->render('update', [
            'model' => $model,
            'regions' => Region::getRegions(),
            'selectedMunicipality' => [$model->province->id => $model->province->name],
            'province' =>  [$model->municipality_city_id => $model->municipalityCity->name],

            // 'selectedProvince' => [$model->province->id => $model->province->name]
        ]);
    }


    protected function findModel($id)
    {
        if (($model = FIC::findOne(['id' => $id])) !== null) {
            $model->province_id = $model->municipalityCity->province_id;
            $model->region_id = $model->municipalityCity->region_id;
            return $model;
        }
    }
}
