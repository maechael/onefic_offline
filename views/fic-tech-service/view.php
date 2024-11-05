<?php

use hail812\adminlte\widgets\Widget;
use yii\helpers\Html;
use kartik\detail\DetailView;

/** @var yii\web\View $this */
/** @var app\models\FicTechService $model */


$this->params['breadcrumbs'][] = ['label' => 'Fic Tech Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fic-tech-service-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'group' => true,
                'label' => '<h4>Technical Services</h4>',
                'rowOptions' => [
                    'class' => 'text-center  table-info'
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'fic',
                        'label' => 'Host Institution',
                        'value' => function ($form, $widget) {
                            return $widget->model->fic->suc;
                        },
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'fic',
                        'label' => 'Region',
                        'value' => function ($form, $widget) {
                            return $widget->model->fic->region->name;
                        },
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'equipment',
                        'label' => 'Equipment',
                        'value' => function ($form, $widget) {
                            return $widget->model->equipment->model;
                        },
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'tech_service_id',
                        'label' => 'Technical Service',
                        'value' => function ($form, $widget) {
                            return $widget->model->techService->name;
                        },
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'charging_type',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'charging_fee',
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],

        ],
    ]) ?>

</div>