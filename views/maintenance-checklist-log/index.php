<?php

use app\models\MaintenanceChecklistLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MaintenanceChecklistLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Maintenance Checklist Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-checklist-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Maintenance Checklist Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fic_equipment_id',
            'accomplished_by_name',
            'accomplished_by_designation',
            'accomplished_by_office',
            //'accomplished_by_date',
            //'endorsed_by_name',
            //'endorsed_by_designation',
            //'endorsed_by_office',
            //'endorsed_by_date',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, MaintenanceChecklistLog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
