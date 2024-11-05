<?php

use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="fic-update">

    <div class="container-fluid">




        <?php $form = ActiveForm::begin() ?>
        <div class="row">

            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'suc')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'contact_person')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'contact_number')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'region_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map($regions, 'id', 'code'),
                    'size' => Select2::SMALL,
                    'options' => ['placeholder' => 'Select a region...'],
                    'pluginOptions' => [
                        //'allowClear' => true
                    ]
                ]) ?>
            </div>
        </div>


        <?php ActiveForm::end() ?>

    </div>





</div>