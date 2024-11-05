<?php

use kartik\date\DatePicker;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<div class="checklist-log-checklist">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-6">
            <div class="card card-light">
                <div class="card-header">
                    <h3 class="card-title">Accomplished by</h3>
                </div>
                <div class="card-body">
                    <?= $form->field($checklistLog, 'accomplished_by_name')->textInput()->label('Name') ?>

                    <?= $form->field($checklistLog, 'accomplished_by_designation')->textInput()->label('Designation') ?>

                    <?= $form->field($checklistLog, 'accomplished_by_office')->textInput()->label('Office') ?>

                    <?= $form->field($checklistLog, 'accomplished_by_date')->widget(DatePicker::class, [
                        'options' => ['placeholder' => 'Enter date ...'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy/mm/dd'
                        ]
                    ])->label('Date') ?>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card card-light">
                <div class="card-header">
                    <h3 class="card-title">Endorsed by</h3>
                </div>
                <div class="card-body">

                    <?= $form->field($checklistLog, 'endorsed_by_name')->textInput()->label('Name') ?>

                    <?= $form->field($checklistLog, 'endorsed_by_designation')->textInput()->label('Designation') ?>

                    <?= $form->field($checklistLog, 'endorsed_by_office')->textInput()->label('Office') ?>

                    <?= $form->field($checklistLog, 'endorsed_by_date')->widget(DatePicker::class, [
                        'options' => ['placeholder' => 'Enter date ...'],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy/mm/dd'
                        ]
                    ])->label('Date') ?>

                </div>
            </div>
        </div>

    </div>


    <?php if (count($checklistCriterias) > 0) : ?>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-light">
                    <th style="width: 15%;" class="text-center">COMPONENT</th>
                    <th style="width: 50%;">CRITERIA</th>
                    <th style="width: 5%;">ACTION</th>
                    <th style="width: 30%;" class="text-center">REMARKS</th>
                </tr>
            </thead>

            <?php
            $groupedComponent =  ArrayHelper::index($checklistCriterias, null, function ($e) {
                return $e['component_name'];
            });
            ?>
            <tbody>
                <?php foreach ($groupedComponent as $i => $component) : ?>
                    <tr>
                        <td rowspan=<?= count($component) + 1 ?> class="align-middle text-center"><?= $i ?></td>
                    </tr>
                    <?php foreach ($component as $j => $checklistCriteria) : ?>
                        <tr>
                            <?= Html::activeHiddenInput($groupedComponent[$i][$j], "[{$i}][{$j}]id") ?>
                            <?= Html::activeHiddenInput($groupedComponent[$i][$j], "[{$i}][{$j}]maintenance_checklist_log_id") ?>
                            <?= Html::activeHiddenInput($groupedComponent[$i][$j], "[{$i}][{$j}]component_name") ?>
                            <?= Html::activeHiddenInput($groupedComponent[$i][$j], "[{$i}][{$j}]criteria") ?>

                            <td><?= $checklistCriteria->criteria ?></td>
                            <td><?= $form->field($groupedComponent[$i][$j], "[{$i}][{$j}]result")->widget(SwitchInput::class, [
                                    'pluginOptions' => [
                                        'size' => 'small',
                                        'onText' => 'Yes',
                                        'offText' => 'No',
                                    ]
                                ]) ?>
                            </td>
                            <td><?= Html::activeTextarea($groupedComponent[$i][$j], "[{$i}][{$j}]remarks", ['rows' => 3, 'cols' => 80]) ?></td>

                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>