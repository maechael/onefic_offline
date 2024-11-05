<?php

use yii\bootstrap4\ActiveForm;



?>
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Change Password</h3>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'form-change-password',
        'action' => 'change-password',
        'method' => 'POST',
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]);
    ?>
    <div class="card-body">
        <div class="form-group">
            <?= $form->field($user, 'oldPassword', ['inputTemplate' => "<div class='input-group-append'>
                {input}<span class='input-group-text'><i class='fas fa-eye' id='showPass'></i></span></div>"])->textInput(['maxlength' => true, 'class' => 'form-control', 'type' => 'password'])->label(false) ?>
        </div>


        <div class="form-group">
            <?= $form->field($user, 'newPassword')->textInput(['maxlength' => true, 'class' => 'form-control', 'type' => 'password']) ?>
        </div>

        <div class="form-group">
            <?= $form->field($user, 'confirmNewPassword')->textInput(['maxlength' => true, 'class' => 'form-control', 'type' => 'password']) ?>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" fdprocessedid="50cd5g">Submit</button>
    </div>
    <?php ActiveForm::end(); ?>


</div>

<?php
$this->registerJs(<<<JS
$('.input-group-text').on('click', function(){
    var passField = $('#userchangepasswordform-oldpassword');
    var passwordFieldType = passField.attr('type');
    if(passwordFieldType == 'password'){
        passField.attr('type', 'text');
         $('#showPass').removeClass('fa-eye').addClass('fa-eye-slash');
    }else{
        passField.attr('type', 'password');
        $('#showPass').removeClass('fa-eye-slash').addClass('fa-eye');
    }
   
});
JS)

?>