<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MaintenanceChecklistLogSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="maintenance-checklist-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fic_equipment_id') ?>

    <?= $form->field($model, 'accomplished_by_name') ?>

    <?= $form->field($model, 'accomplished_by_designation') ?>

    <?= $form->field($model, 'accomplished_by_office') ?>

    <?php // echo $form->field($model, 'accomplished_by_date') ?>

    <?php // echo $form->field($model, 'endorsed_by_name') ?>

    <?php // echo $form->field($model, 'endorsed_by_designation') ?>

    <?php // echo $form->field($model, 'endorsed_by_office') ?>

    <?php // echo $form->field($model, 'endorsed_by_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
