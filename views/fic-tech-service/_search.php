<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\FicTechServiceSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fic-tech-service-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fic_id') ?>

    <?= $form->field($model, 'fic_equipment_id') ?>

    <?= $form->field($model, 'tech_service_id') ?>

    <?= $form->field($model, 'charging_type') ?>

    <?php // echo $form->field($model, 'charging_fee') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
