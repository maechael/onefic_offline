<?php

use app\models\FicEquipment;
use kartik\editors\Summernote;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $model app\modules\ficModule\models\FicEquipment */
?>
<?php Modal::begin([
    'id' => 'modal-update-status',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Status Update',
    'size' => 'modal-lg',
]); ?>
<div class="update-status-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-status-update',
        'action' => Url::to(['update-status', 'id' => $model->id]),
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ]
    ]); ?>
    <?= $form->field($model, 'status')->widget(Select2::class, [
        'data' => [
            FicEquipment::STATUS_SERVICEABLE => 'Serviceable',
            FicEquipment::STATUS_UNSERVICEABLE => 'Unserviceable'
        ],
        'theme' => Select2::THEME_BOOTSTRAP,
        // 'options' => ['placeholder' => 'Select an equipment...'],
        // 'pluginOptions' => [
        //     'allowClear' => true
        // ]
    ]) ?>

    <?= $form->field($model, 'remarks')->widget(Summernote::class, [
        'useKrajeePresets' => true,
        'pluginOptions' => [
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
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php Modal::end();
