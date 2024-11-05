<?php

use app\models\EquipmentIssue;
use kartik\editors\Summernote;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

?>
<?php Modal::begin([
    'id' => 'modal-create',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Add Repair Activity',
    'size' => 'modal-xl',
]); ?>
<div class="repair-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create-repair',
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ]
    ]); ?>

    <?= Html::activeHiddenInput($model, "equipment_issue_id", ['value' => $equipment_issue_id]); ?>

    <?= Html::activeHiddenInput($model, "equipment_issue_gid", ['value' => $equipment_issue_gid]); ?>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'performed_by')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'issue_status')->widget(Select2::class, [
                'value' => EquipmentIssue::STATUS_OPEN,
                'data' => [
                    EquipmentIssue::STATUS_OPEN => 'OPEN',
                    EquipmentIssue::STATUS_CLOSED => 'CLOSE'
                ],
                'theme' => Select2::THEME_BOOTSTRAP,
                'hideSearch' => true,
            ]); ?>
        </div>
    </div>


    <?= $form->field($model, 'repair_activity')->widget(Summernote::class, [
        'useKrajeePresets' => true,
        'pluginOptions' => [
            'height' => 200,
            'toolbar' => [
                ['style1', ['style']],
                ['style2', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
                ['font', ['fontname', 'fontsize', 'color', 'clear']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                // ['insert', ['link', 'picture', 'video', 'table', 'hr']],
            ],
        ],
        'container' => [
            'class' => ''
        ]
    ]) ?>

    <?= $form->field($model, 'remarks')->widget(Summernote::class, [
        'useKrajeePresets' => true,
        'pluginOptions' => [
            'height' => 200,
            'toolbar' => [
                ['style1', ['style']],
                ['style2', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
                ['font', ['fontname', 'fontsize', 'color', 'clear']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                // ['insert', ['link', 'picture', 'video', 'table', 'hr']],
            ],
        ],
        'container' => [
            'class' => ''
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success float-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php Modal::end(); ?>