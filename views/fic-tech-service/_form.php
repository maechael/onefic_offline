<?php

use app\models\FicTechService;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\FicTechService $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="fic-tech-service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($model, "fic_id"); ?>

    <?= $form->field($model, 'equipment_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($equipments, 'id', 'model'),
        // 'theme' => Select2::THEME_BOOTSTRAP,
        // 'hashVarLoadPosition' => View::POS_READY,
        'options' => ['placeholder' => 'Select an equipment...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($model, 'tech_service_id')->widget(DepDrop::class, [
        'bsVersion' => '4.x',
        'data' => [],
        'type' => DepDrop::TYPE_SELECT2,
        'pluginOptions' => [
            'depends' => ['fictechservice-equipment_id'],
            'placeholder' => 'Select a tech service...',
            'url' => Url::to(['/tech-service/get-tech-service'])
        ],
    ]) ?>

    <?= $form->field($model, 'charging_type')->widget(Select2::class, [
        'data' => [
            FicTechService::CHARGE_TYPE_PER_DAY => FicTechService::CHARGE_TYPE_PER_DAY,
            FicTechService::CHARGE_TYPE_PER_HOUR => FicTechService::CHARGE_TYPE_PER_HOUR,
            FicTechService::CHARGE_TYPE_PER_USE => FicTechService::CHARGE_TYPE_PER_USE,
        ],
        'options' => ['placeholder' => 'Select a charging type...'],
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


</div>