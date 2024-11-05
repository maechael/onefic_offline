<?php

use app\models\FicEquipment;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\FicEquipment */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->equipment->model;
\yii\web\YiiAsset::register($this);

$groupedHistory = ArrayHelper::index($model->ficEquipmentStatusHistory, null, function ($element) {
    return Yii::$app->formatter->asDate($element['created_at']);
});
?>
<div class="fic-equipment-view">
    <div class="row">

        <!-- Left Side -->
        <div class="col-md-3">

            <!-- Profile Pic Card -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">

                    <?= Html::img(isset($model->equipment->image) ? $model->equipment->image->link : "", ['class' => 'img-fluid pad rounded', 'alt' => $model->equipment->model]) ?>

                    <hr>

                    <div class="d-flex">
                        <?= Html::a('<i class="fas fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm flex-fill']) ?>
                        <?= Html::a('<i class="fas fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm flex-fill ml-1',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>
            <!-- Profile Pic Card End -->

        </div>
        <!-- Left Side End -->

        <!-- Right Side -->
        <div class="col-md-9">

            <div class="row">
                <div class="col-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $model->issueCount ?></h3>
                            <p>Issues</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['issues', 'fic_equipment_id' => $model->id], ['class' => 'small-box-footer']) ?>
                    </div>
                </div>

                <div class="col-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= isset($model->latestMaintenanceLog) ? $model->latestMaintenanceLog->maintenance_date : "0000-00-00" ?></h3>
                            <p>Maintenance Log</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                        <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', Url::to(['equipment-maintenance-log/maintenance-list', 'fic_equipment_id' => $model->id]), ['class' => 'small-box-footer']) ?>
                    </div>
                </div>

                <div class="col-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>5</h3>
                            <p>Maintenance Checklist Log</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['/maintenance-checklist-log/fic-equipment', 'id' => $model->id], ['class' => 'small-box-footer']) ?>
                    </div>
                </div>
            </div>
            <?php Pjax::begin(); ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    // [
                    //     'group' => true,
                    //     'label' => 'EQUIPMENT INFORMATION',
                    //     'rowOptions' => [
                    //         'class' => 'table-info'
                    //     ]
                    // ],
                    [
                        'columns' => [
                            ['attribute' => 'serial_number', 'valueColOptions' => ['style' => 'width:20%']],
                            [
                                'attribute' => 'equipmentStatus',
                                'valueColOptions' => ['style' => 'width:40%']
                            ]

                        ]
                    ],
                    [
                        'columns' => [
                            [
                                'attribute' => 'equipment',
                                'label' => 'Equipment Type',
                                'value' => $model->equipment->equipmentType->name,
                                'valueColOptions' => ['style' => 'width:20%'],
                            ],
                            [
                                'attribute' => 'equipment',
                                'label' => 'Equipment Category',
                                'value' => $model->equipment->equipmentCategory->name,
                                'valueColOptions' => ['style' => 'width:40%'],
                            ],
                        ]
                    ],
                    // [
                    //     'attribute' => 'remarks',
                    //     'format' => 'raw'
                    // ],
                    // [
                    //     'attribute' => 'equipment',
                    //     'label' => false,
                    //     'labelColOptions' => ['class' => 'd-none'],
                    //     'format' => 'raw',
                    //     'value' => $this->render('_equipment-specification', [
                    //         'model' => $model->equipment
                    //     ])
                    // ]
                ],
                'mode' => DetailView::MODE_VIEW,
                'enableEditMode' => true,
                'bordered' => true,
                'striped' => false,
                'condensed' => false,
                'responsive' => true,
                'hover' => false,
                'hideIfEmpty' => false,
                'notSetIfEmpty' => true,
                'hAlign' => DetailView::ALIGN_RIGHT,
                'vAlign' => DetailView::ALIGN_MIDDLE,
                'panel' => [
                    'type' => DetailView::TYPE_PRIMARY,
                    'heading' => "<i class='fas fa-toolbox'></i> {$model->equipment->model}"
                ],
                'buttons1' => Html::button('<i class="fas fa-pencil-alt"></i>', ['class' => 'kv-action-btn status-update-btn',])
            ]); ?>
            <?php Pjax::end(); ?>

            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">
                        <h5 class="mb-0">Equipment Status History</h5>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (count($model->ficEquipmentStatusHistory) == 0) : ?>
                        <div class="alert alert-info">
                            No Equipment Status Update.
                        </div>
                    <?php endif; ?>
                    <?php if (count($model->ficEquipmentStatusHistory) > 0) : ?>
                        <div class="timeline">
                            <?php foreach ($groupedHistory as $date => $updates) : ?>
                                <div class="time-label">
                                    <span class="bg-secondary"><?= $date ?></span>
                                </div>
                                <?php foreach ($updates as $update) : ?>
                                    <div>
                                        <i class="fas fa-pencil-alt bg-purple"></i>
                                        <div class="timeline-item">
                                            <span class="time">
                                                <i class="fas fa-clock"></i> <?= Yii::$app->formatter->asTime($update->created_at) ?>
                                            </span>
                                            <h3 class="timeline-header">
                                                <?php
                                                echo "{$update->createdBy->userProfile->lastname} changed the status to {$model->equipmentStatus}";
                                                ?>
                                            </h3>
                                            <div class="timeline-body">
                                                <?= $update->remarks ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            <?php endforeach; ?>
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <!-- Right Side End -->
    </div>

</div>
<?= $this->render('_update-status', [
    'model' => $model
]); ?>
<?php
$this->registerJs(<<<JS
    $('body').on('click', '.status-update-btn', (e) => {
        $('#modal-update-status').modal('show');
    });

    $('#form-status-update').on('beforeSubmit', function(){
        let yiiform = $(this);
        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray()
        }).done(data => {
            if(data.success){
                $('#modal-update-status').modal('hide');
                yiiform.trigger('reset');
                $.pjax.reload({container:'#p0'});
            }else if(data.validation){
                yiiform.yiiActiveForm('updateMessages', data.validation, true);
            }
        }).fail(() => {

        });
        
        return false;
    });
JS);
