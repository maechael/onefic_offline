<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MaintenanceChecklistLog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="maintenance-checklist-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fic_equipment_id')->textInput() ?>

    <?= $form->field($model, 'accomplished_by_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accomplished_by_designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accomplished_by_office')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accomplished_by_date')->textInput() ?>

    <?= $form->field($model, 'endorsed_by_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endorsed_by_designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endorsed_by_office')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'endorsed_by_date')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
