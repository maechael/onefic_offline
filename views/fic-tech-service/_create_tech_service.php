<?php

use app\models\TechService;
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

<?php Modal::begin([
    'id' => 'modal-create-tech-service',
    'title' => 'Add Tech Service',
    'size' => 'modal-md',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>

<div class="form-group">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => '/fic-tech-service/create',
        'options' => [],
        'method' => 'POST',
    ]); ?>

    <?= $form->field($model, 'equipment_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($equipments, 'id', 'model'),
        // 'theme' => Select2::THEME_BOOTSTRAP,
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
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end();

$this->registerJs(<<<JS
    $('#form-create').on('beforeSubmit', function() {
        let yiiform = $(this);
        let test = yiiform.serialize();

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
            
        }).done(data => {
            if(data.success){
                $('#modal-create-tech-service').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container:'#ficTechServiceGrid'}); //..reload gridview
            } else if (data.validation) {
                yiiform.yiiActiveForm('updateMessages', data.validation, true);
            } else {
                // incorrect server response
            }
        }).fail(() => {
            // request failed
        });

        return false;
    });
JS);
