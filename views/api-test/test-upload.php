<?php

use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

?>
<div class="test-upload-view">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        // 'action' => 'http://ficphil.local.test/v1/media/upload',
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ]
    ]); ?>

    <?= FileInput::widget([
        'name' => 'equipmentIssueImages[]',
        // 'name' => 'equipmentIssueImages',
        'options' => [
            'id' => 'sd-equipment-issue-images',
            'multiple' => true,
            'accept' => 'image/*'
        ],
        'pluginOptions' => [
            // 'uploadUrl' => 'http://ficphil.local.test/v1/media/upload',
            'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
            'maxFileCount' => 10,
            'showUpload' => true,
            'showCancel' => false
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success float-right']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>