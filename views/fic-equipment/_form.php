<?php

use app\models\FicEquipment;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\FicEquipment */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="fic-equipment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equipment_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($equipments, 'id', 'model'),
        // 'size' => Select2::SMALL,
        'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Select an equipment...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($model, 'serial_number')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'status')->widget(Select2::class, [
        'value' => FicEquipment::STATUS_SERVICEABLE,
        'data' => [
            FicEquipment::STATUS_SERVICEABLE => 'serviceable',
            FicEquipment::STATUS_UNSERVICEABLE => 'unserviceable'
        ],
        // 'size' => Select2::SMALL,
        'theme' => Select2::THEME_BOOTSTRAP,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>