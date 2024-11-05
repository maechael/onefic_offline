<?php

use app\assets\FilterMultiSelectAsset;
use app\models\Equipment;
use app\models\Part;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierSearch */
/* @var $form yii\widgets\ActiveForm */

FilterMultiSelectAsset::register($this);
?>

<div class="row mt-2">
    <div class="col-md-12">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <div class="card">
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'equipments')->widget(Select2::class, [
                            'data' => ArrayHelper::map(Equipment::getEquipments(), 'id', 'model'),
                            'theme' => Select2::THEME_DEFAULT,
                            'showToggleAll' => true,
                            // 'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Select equipments ...',
                                'multiple' => true,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'closeOnSelect' => false,
                                'dropdownAutoWidth' => true,
                                // 'selectionCssClass' => 'form-control',
                                'width' => '100%',
                                'scrollAfterSelect' => false,
                            ],
                        ]) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'parts')->widget(Select2::class, [
                            'data' => ArrayHelper::map(Part::getParts(), 'id', 'name'),
                            'theme' => Select2::THEME_DEFAULT,
                            'showToggleAll' => true,
                            // 'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Select parts ...',
                                'multiple' => true,
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'closeOnSelect' => false,
                                'dropdownAutoWidth' => true,
                                // 'selectionCssClass' => 'form-control',
                                'width' => '100%',
                                'scrollAfterSelect' => false,
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>