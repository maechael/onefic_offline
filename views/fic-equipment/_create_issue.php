<?php

use app\models\Part;
use kartik\editors\Summernote;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php Modal::begin([
    'id' => 'modal-create',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Create Issue',
    'size' => 'modal-xl',
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create-issue',
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ]
    ]); ?>

    <?= $form->field($issue, 'fic_equipment_id')->hiddenInput(['value' => $fic_equipment_id])->label(false) ?>

    <?= $form->field($issue, 'fic_equipment_gid')->hiddenInput(['value' => $ficEquipment->global_id])->label(false) ?>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <?= $form->field($issue, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12">
            <?= $form->field($issue, 'reported_by')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?= $form->field($issue, 'relatedComponentIds')->widget(Select2::class, [
        'data' => ArrayHelper::map($components, 'id', 'name'),
        'theme' => Select2::THEME_DEFAULT,
        'showToggleAll' => true,
        'options' => [
            'multiple' => true,
            'placeholder' => 'Select related component(s)...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'closeOnSelect' => false,
            'dropdownAutoWidth' => true,
            'width' => '100%',
            'scrollAfterSelect' => false
        ]
    ]) ?>

    <?= $form->field($issue, 'relatedPartIds')->widget(Select2::class, [
        'data' => ArrayHelper::map($parts, 'id', 'name'),
        'theme' => Select2::THEME_DEFAULT,
        'showToggleAll' => true,
        'options' => [
            'multiple' => true,
            'placeholder' => 'Select related part(s)...',
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'closeOnSelect' => false,
            'dropdownAutoWidth' => true,
            'width' => '100%',
            'scrollAfterSelect' => false
        ]
    ]) ?>

    <?= $form->field($issue, 'description')->widget(Summernote::class, [
        'useKrajeePresets' => true,
        'pluginOptions' => [
            'toolbar' => [
                ['style1', ['style']],
                ['style2', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
                ['font', ['fontname', 'fontsize', 'color', 'clear']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                // ['insert', ['link', 'picture', 'video', 'table', 'hr']],
            ],
        ],
        'container' => [
            'class' => ''
        ]
    ]) ?>

    <?= $form->field($issue, 'equipmentIssueImgs[]')->widget(FileInput::class, [
        'name' => 'equipmentIssueImages[]',
        'options' => [
            'id' => 'sd-equipment-issue-images',
            'multiple' => true,
            'accept' => 'image/*'
        ],
        'pluginOptions' => [
            'allowedFileExtensions' => ['png', 'jpg', 'jpeg'],
            'maxFileCount' => 10,
            'showUpload' => false,
            'showCancel' => false
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success float-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end();

$this->registerJs(<<<JS
    $('#form-create').on('beforeSubmit', function() {
        let yiiform = $(this);
        let test = yiiform.serialize();
        let formData = new FormData($(this)[0]);

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            processData: false,
            contentType: false,
            cache: false,
            data: formData
            // data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                $('#modal-create').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                   //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container:'#equipment-issues-grid'}); //..reload gridview
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
