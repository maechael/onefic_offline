<?php

use app\models\EquipmentIssue;
use app\models\EquipmentIssueRepair;
use kartik\detail\DetailView;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\i18n\Formatter;
use yii\widgets\Pjax;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $issue->ficEquipment->equipment->model, 'url' => ['view', 'id' => $issue->ficEquipment->id]];
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['issues', 'fic_equipment_id' => $issue->ficEquipment->id]];
$this->params['breadcrumbs'][] = StringHelper::truncate($issue->title, 50);

$groupedRepairs = ArrayHelper::index($issue->equipmentIssueRepairs, null, function ($element) {
    return Yii::$app->formatter->asDate($element['created_at']);
});
?>
<div class="equipment-issue-view">
    <?php Pjax::begin(); ?>
    <?= DetailView::widget([
        'model' => $issue,
        'attributes' => [
            [
                'group' => true,
                'label' => 'ISSUE DETAILS',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'equipment',
                        'value' => $issue->equipment->model,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'statusDisplay',
                        'label' => 'Status',
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'reported_by',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'created_by',
                        'value' => function ($form, $widget) {
                            $user = $widget->model->createdBy;
                            return isset($user) ? $user->userProfile->lastname : null;
                        },
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'attribute' => 'issueRelatedComponents',
                'label' => 'Related Component(s)',
                'format' => 'raw',
                'value' => function ($form, $widget) {
                    return array_reduce($widget->model->issueRelatedComponents, function ($carry, $item) {
                        if (!isset($item->component))
                            return null;
                        return $carry . Html::button($item->component->name, ['class' => 'btn btn-secondary btn-sm mr-1 mb-1']);
                    }, '');
                }
            ],
            [
                'attribute' => 'issueRelatedParts',
                'label' => 'Related Part(s)',
                'format' => 'raw',
                'value' => function ($form, $widget) {
                    return array_reduce($widget->model->issueRelatedParts, function ($carry, $item) {
                        if (!isset($item->part))
                            return null;
                        return $carry . Html::button($item->part->name, ['class' => 'btn btn-secondary btn-sm mr-1 mb-1']);
                    }, '');
                }
            ],
            [
                'attribute' => 'description',
                'format' => 'html'
            ],
            [
                'group' => true,
                'label' => 'RELATED IMAGE(S)',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'attribute' => 'equipmentIssueImages',
                'label' => 'Image(s)',
                'format' => 'raw',
                'value' => function ($form, $widget) {
                    return FileInput::widget([
                        'name' => 'asdf',
                        'options' => [
                            'multiple' => true,
                            'accept' => 'image/*',
                        ],
                        'pluginOptions' => [
                            'showCancel' => false,
                            'showBrowse' => false,
                            'showRemove' => false,
                            'showClose' => false,
                            'inputGroupClass' => 'd-none',
                            'initialPreviewAsData' => true,
                            'initialPreviewShowDelete' => false,
                            'initialPreviewDownloadUrl' => false,
                            'overwriteInitial' =>  true,
                            'dropZoneTitle' => 'No image(s) provided...',
                            'allowedFileExtensions' => ["png", "jpg", "jpeg"],
                            'initialPreview' => $widget->model->issueImagePreviews['previews'],
                            'initialPreviewConfig' => $widget->model->issueImagePreviews['configs'],
                        ]
                    ]);
                }
            ],
        ],
        'mode' => DetailView::MODE_VIEW,
        'enableEditMode' => false,
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
            'heading' => "<i class='fas fa-exclamation-triangle'></i> {$issue->equipment->model} ({$issue->title})"
        ],
        // 'labelColOptions' => ['class' => 'bg-accent3']
    ]) ?>

    <div class="card card-primary">
        <div class="card-header">
            <div class="card-title">
                <h5 class="mb-0">Repair/Rehabilitation Activity</h5>
            </div>
            <div class="card-tools">
                <?php if ($issue->status == EquipmentIssue::STATUS_OPEN) : ?>
                    <?= Html::button('<span class="fas fa-plus"></span>', ['class' => 'btn btn-tool btn-repair', 'data-pjax' => 0, 'id' => 'btn-repair']) ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($groupedRepairs) == 0) : ?>
                <div class="alert alert-info">
                    No repair activity have been performed.
                </div>
            <?php endif; ?>
            <?php if (count($groupedRepairs) > 0) : ?>
                <div class="timeline">
                    <?php foreach ($groupedRepairs as $date => $repairs) : ?>
                        <div class="time-label">
                            <span class="bg-secondary"><?= $date ?></span>
                        </div>
                        <?php foreach ($repairs as $repair) : ?>
                            <div>
                                <i class="fas fa-wrench bg-purple"></i>
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="fas fa-clock"></i> <?= Yii::$app->formatter->asTime($repair->created_at) ?>
                                    </span>
                                    <h3 class="timeline-header">
                                        <?= $repair->performed_by ?>
                                    </h3>
                                    <div class="timeline-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <label>Repair Activity:</label>
                                            </div>
                                            <?php if (!$repair->remarks == null) : ?>
                                                <div class="col-6">
                                                    <label>Remarks:</label>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <?= $repair->repair_activity ?>
                                            </div>
                                            <?php if (!$repair->remarks == null) : ?>
                                                <div class="col-6">
                                                    <?= $repair->remarks ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
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
    <?php Pjax::end(); ?>
</div>
<?php
echo $this->render('_create-repair-activity', [
    'model' => $equipmentIssueRepair,
    'equipment_issue_id' => $issue->id,
    'equipment_issue_gid' => $issue->global_id,
]);
$this->registerJs(<<<JS
    $('body').on('click', '.btn-repair', (e) => {
        $('#modal-create').modal('show');
    });

    $('#form-create').on('beforeSubmit', function() {
        let yiiform = $(this);
        let test = yiiform.serialize();

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                $('#modal-create').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                   //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container: '#p0'});
            } else if (data.validation) {
                yiiform.yiiActiveForm('updateMessages', data.validation, true);
            } else {
                // incorrect server response
            }
        }).fail(() => {
            // request failed
        });

        return false;
    });
JS);
