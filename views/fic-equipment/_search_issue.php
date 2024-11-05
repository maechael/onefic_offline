<?php

use app\models\Equipment;
use app\models\EquipmentIssue;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EquipmentIssueSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row mt-2">
    <div class="col-md-12">

        <?php $form = ActiveForm::begin([
            'action' => ['issues'],
            'method' => 'get',
        ]); ?>
        <?= $form->field($model, 'fic_equipment_id')->hiddenInput(['value' => $ficEquipmentId])->label(false) ?>
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'title')->textInput(['class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'status')->widget(Select2::class, [
                            'data' => [
                                '' => 'All',
                                EquipmentIssue::STATUS_OPEN => 'Open',
                                EquipmentIssue::STATUS_CLOSED => 'Closed'
                            ],
                            'size' => Select2::SMALL,
                            //'theme' => SELECT2::THEME_CLASSIC
                        ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group float-right">
                            <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-sm']) ?>
                            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary btn-sm']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>