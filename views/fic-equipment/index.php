<?php

use app\models\FicEquipment;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\JsExpression;
use edofre\fullcalendar\Fullcalendar;
use edofre\fullcalendar\models\Event;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ficModule\models\FicEquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = "{$fic->name} Equipments";

?>
<div class="fic-equipment-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute' => 'equipment',
                // 'value' => 'equipment.model',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->equipment->model), ['fic-equipment/view', 'id' => $model->id]);
                },
                'format' => 'raw',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'serial_number',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    if ($model->status == FicEquipment::STATUS_SERVICEABLE)
                        return "serviceable";
                    else if ($model->status == FicEquipment::STATUS_UNSERVICEABLE)
                        return "unserviceable";
                    else
                        return "unserviceable";
                },
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => [
                    FicEquipment::STATUS_SERVICEABLE => 'serviceable',
                    FicEquipment::STATUS_UNSERVICEABLE => 'unserviceable'
                ],
                'filterWidgetOptions' => [
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => 'status',
                    ],
                    'pluginOptions' => ['allowClear' => true],
                    'size' => Select2::SMALL,
                    'hideSearch' => true,
                ],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
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
                'attribute' => 'updated_at',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
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
                'class' => 'kartik\grid\ActionColumn',
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
            'heading' => '<i class="fas fa-toolbox"></i> Equipments',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => Html::button('<i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-fic-equipment', 'class' => 'btn btn-default btn-sm']) .
                    Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
            ],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]); ?>

</div>
<?php
//..Create Equipment Modal
echo $this->render('_create_equipment', ['ficEquipment' => $ficEquipment, 'equipments' => $equipments]);
