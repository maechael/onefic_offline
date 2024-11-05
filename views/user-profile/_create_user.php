<?php

use app\models\Equipment;
use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\ProcessingCapability;
use app\modules\ficModule\models\FicEquipment;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\ContactDetail;
use app\models\Designation;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\Pjax;
use yii\web\View;


?>
<?php Modal::begin([
    'id' => 'modal-create-user',
    'title' => 'Add User',
    'size' => 'modal-lg',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-signup',
        'action' => 'signup',
        'options' => [],
        'method' => 'POST',
        'layout' => 'default',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-4',
                'offset' => 'offset-sm-4',
                'wrapper' => 'col-sm-8',
                'error' => '',
                'hint' => '',
            ]
        ]

    ]); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'firstname')->textInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'middlename')->textInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'lastname')->textInput(['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'email')->input('email', ['class' => 'form-control form-control-sm']) ?>
    <?= $form->field($model, 'designation_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Designation::getDesignations(), 'id', 'description'),
        'size' => Select2::SMALL,
        'options' => ['placeholder' => 'Select a designation...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <div class="col-md-12 col-sm-12">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
            'widgetBody' => '.container-items', // required: css class selector
            'widgetItem' => '.item', // required: css class
            'limit' => 4, // the maximum times, an element can be cloned (default 999)
            'min' => 0, // 0 or 1 (default 1)
            'insertButton' => '.add-item', // css class
            'deleteButton' => '.remove-item', // css class
            'model' => $contacts[0],
            'formId' => 'form-signup',
            'formFields' => [
                'contact_type',
                'contact'
            ],
        ]); ?>

        <div class="card mb-1">
            <div class="card-header">
                <span>
                    <span class="fas fa-address-card align-middle"></span> Contact Details
                    <button type="button" class="add-item btn btn-success btn-sm float-right"><i class="fas fa-plus"></i> Add</button>
                </span>
            </div>
            <div class="card-body">
                <div class="container-items">
                    <?php foreach ($contacts as $i => $contact) : ?>
                        <div class="item">

                            <div class="row">
                                <div class="col-lg-5 col-md-12">
                                    <?php
                                    // necessary for update action.
                                    if (!$contact->isNewRecord) {
                                        echo Html::activeHiddenInput($contact, "[{$i}]id");
                                    }

                                    // echo $form->field($contact, "[{$i}]contact_type", [
                                    //     'template' => '<div class="row"><div class="col-3 text-right">{label}</div><div class="col-9">{input}{error}{hint}</div></div>',

                                    // ])->textInput(['class' => 'form-control form-control-sm'])->label('Type')

                                    echo $form->field($contact, "[{$i}]contact_type", [
                                        'template' => '<div class="row"><div class="col-3 text-right">{label}</div><div class="col-9">{input}{error}{hint}</div></div>'
                                    ])->dropdownList([
                                        ContactDetail::TYPE_TELEPHONE => 'Telephone',
                                        ContactDetail::TYPE_CELLPHONE => 'Cellphone',
                                        ContactDetail::TYPE_EMAIL => 'Email'
                                    ], [
                                        'value' => ContactDetail::TYPE_CELLPHONE,
                                        'class' => 'form-control form-control-sm contact_field'
                                    ])
                                    ?>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <?= $form->field($contact, "[{$i}]contact", [
                                        // 'enableClientValidation' => false,
                                        // 'enableAjaxValidation' => false,
                                        'template' => '<div class="row"><div class="col-3 text-right">{label}</div><div class="col-9">{input}{error}{hint}</div></div>',

                                    ])->textInput(['class' => 'form-control form-control-sm contact_input']) ?>
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <button type="button" class="remove-item btn btn-danger btn-sm btn-block mb-1">Remove</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>



    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>



    <?php Modal::end();


    $this->registerJs(<<<JS
    $('#form-signup').on('beforeSubmit', function() {
        let yiiform = $(this);
        // console.log(yiiform.yiiActiveForm('find', 'equipment-imagefile').value);
        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
            
        }).done(data => {
            if(data.success){
                $('#modal-create-user').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                swal({
                    title: 'Sucess',
                    text: 'Facility successfully created!',
                    type: "success"
                });
                $.pjax.reload({container:'#userGrid'}); //..reload gridview
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
