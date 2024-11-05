<?php

use app\models\FicTechService;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use kartik\number\NumberControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

?>
<div class="facility-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/fic-tech-service/update?id={$model->id}",
        'options' => [
            //'data-pjax' => true
        ]
    ]); ?>

    <?= $form->field($model, 'equipment_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($equipments, 'id', 'model'),
        // 'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Select an equipment...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>



    <?= $form->field($model, 'charging_fee')->widget(NumberControl::class, [
        'maskedInputOptions' => [
            'prefix' => '₱ ',
            'allowMinus' => false
        ],
        'displayOptions' => ['class' => 'form-control kv-monospace'],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>
</div>