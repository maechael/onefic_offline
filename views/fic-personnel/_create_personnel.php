<?php

use app\models\Designation;
use app\models\Fic;
use app\models\UserProfile;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<?php Modal::begin([
    'id' => 'modal-create-fic-personnel',
    'title' => 'Sign Up',
    'size' => 'modal-md',
]); ?>
<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]) ?>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control form-control-sm']) ?>

    <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-sm']) ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fic_affiliation')->widget(Select2::class, [
        'data' => ArrayHelper::map(Fic::getFics(), 'id', 'name'),
        'options' => ['placeholder' => 'Select Affliation...'],
    ]) ?>
    <?= $form->field($model, 'designation_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Designation::getDesignations(), 'id', 'name'),
        'options' => ['placeholder' => 'Select Designation...'],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php Modal::end();
