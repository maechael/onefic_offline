<?php

use kartik\date\DatePicker;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\bootstrap4\Html;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['fic-equipment/index']];
$this->params['breadcrumbs'][] = ['label' => $ficEquipment->equipment->model, 'url' => ['fic-equipment/view', 'id' => $ficEquipment->id]];
$this->params['breadcrumbs'][] = 'Checklist Logs';
?>
<div class="checklist-log-fic-equipment">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'accomplished_by_name',
            "accomplished_by_office",
            [
                'attribute' => 'accomplished_by_date',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => null
                ],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ],

            'endorsed_by_name',
            "endorsed_by_office",
            [
                'attribute' => 'endorsed_by_date',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => null
                ],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{pdf-export} {view} {delete}',
                'buttons' => [
                    'pdf-export' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-file-pdf"></span>', $url, ['target' => '_blank']);
                    },
                ]
            ],
        ],
        'beforeHeader' => [
            [
                'columns' =>
                [
                    ['content' => 'Accomplished by', 'options' => ['colspan' => 3, 'class' => 'text-center bg-info']],
                    ['content' => 'Endorsed by', 'options' => ['colspan' => 3, 'class' => 'text-center bg-info']]
                ]
            ]

        ],
        'toolbar' => [
            [
                'content' =>
                Html::a('<i class="fas fa-plus"></i>', ['checklist', 'id' => $ficEquipment->id], ['class' => 'btn btn-sm btn-default']) .
                    Html::a('<i class="fas fa-redo-alt"></i>', ['', 'id' => $ficEquipment->id], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => false,
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficEquipmentGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Maintenance Checklist Log Listing',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]) ?>
</div>