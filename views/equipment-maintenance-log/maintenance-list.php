<?php

use kartik\grid\ExpandRowColumn;
use kartik\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "";
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => '../fic-equipment/index'];
$this->params['breadcrumbs'][] = ['label' => "{$ficEquipment->equipment->model}", 'url' => Url::to(['fic-equipment/view', 'id' => $ficEquipment->id])];
$this->params['breadcrumbs'][] = 'Maintenance List';
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => ExpandRowColumn::class,
            'width' => '60px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detailUrl' => Url::to(['log-details']),
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
            'enableRowClick' => true
        ],
        ['class' => 'kartik\grid\SerialColumn'],
        'maintenance_date',
        [
            'attribute' => 'time_started',
        ],
        [
            'attribute' => 'time_ended'
        ],
        // [
        //     'attribute' => 'equipment.model',
        // ],
        [
            'attribute' => 'inspected_checked_by',
            'label' => 'Inspected By'
        ],
        [
            'attribute' => 'noted_by',
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="fas fa-eye"></span>', $url);
                }
            ],
            'template' => '{view}',
            'dropdown' => false,
            'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
            'dropdownMenu' => ['class' => 'text-left']
        ],

    ],
    'responsive' => true,
    'hover' => true,
    'condensed' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'id' => 'ficEquipmentGrid'
        ]
    ],
    'floatHeader' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<i class="fas fa-tools"></i> Maintenance Log',
        'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
    ],
    'toolbar' => [
        [
            'content' => Html::a('<i class="fas fa-plus"></i>', ['maintain', 'id' => $ficEquipment->id], ['class' => 'btn btn-default btn-sm']) .
                Html::a('<i class="fas fa-redo-alt"></i>', ['', 'fic_equipment_id' => $ficEquipment->id], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                '{toggleData}' .
                '{export}'
        ],
    ],
    'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
    'exportContainer' => ['class' => 'btn-group-sm ml-1']
]) ?>