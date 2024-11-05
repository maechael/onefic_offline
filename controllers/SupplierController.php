<?php

namespace app\controllers;

use app\models\Supplier;
use app\models\SupplierSearch;
use Yii;
use yii\web\NotFoundHttpException;

class SupplierController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $supplier = $this->findModel($id);
        $filePreviews = [];
        $previewConfigs = [];
        //..shortcut version of getting filepaths as array
        // $filePreviews = ArrayHelper::getColumn($supplier->medias, 'filepath');
        foreach ($supplier->medias as $media) {
            $filePreviews[] = $media->link;
            $previewConfigs[] = array("type" => $media->previewType, "caption" => $media->basename, "key" => $media->id);
        }

        return $this->render('view', [
            'model' => $supplier,
            'filePreviews' => $filePreviews,
            'previewConfigs' => $previewConfigs
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
