<?php

use app\models\FicEquipment;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php Modal::begin([
    'id' => 'modal-create-fic-equipment',
    'title' => 'Add Equipment',
    'size' => 'modal-md',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ]
    ]); ?>

    <?= $form->field($ficEquipment, 'equipment_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($equipments, 'id', 'model'),
        // 'size' => Select2::SMALL,
        'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => 'Select an equipment...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($ficEquipment, 'serial_number')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>

    <?= $form->field($ficEquipment, 'status')->widget(Select2::class, [
        'value' => FicEquipment::STATUS_SERVICEABLE,
        'data' => [
            FicEquipment::STATUS_SERVICEABLE => 'serviceable',
            FicEquipment::STATUS_UNSERVICEABLE => 'unserviceable'
        ],
        // 'size' => Select2::SMALL,
        'theme' => Select2::THEME_BOOTSTRAP,
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
                $('#modal-create-fic-equipment').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                   //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container:'#ficEquipmentGrid'}); //..reload gridview
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
