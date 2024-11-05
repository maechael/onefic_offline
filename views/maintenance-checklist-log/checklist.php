<?php

use kartik\date\DatePicker;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/**
 * @var $ficEquipment app\models\FicEquipment
 * @var $checklistLog app\models\MaintenanceChecklistLog
 * @var $checklistComponentTemplates app\models\ChecklistComponentTemplate[]
 * @var $checklistCriterias app\models\ChecklistCriteria[][]
 */

$this->title = '';
// $this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['fic-equipment/index']];
$this->params['breadcrumbs'][] = ['label' => $ficEquipment->equipment->model, 'url' => ['fic-equipment/view', 'id' => $ficEquipment->id]];
$this->params['breadcrumbs'][] = ['label' => "Checklist Logs", 'url' => ['fic-equipment', 'id' => $ficEquipment->id]];
$this->params['breadcrumbs'][] = 'Maintenance Checklist';
?>
<div class="checklist-log-checklist">
    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($checklistLog, "fic_equipment_id", ['value' => $ficEquipment->id]); ?>

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

    <?php if (count($checklistComponentTemplates) > 0) : ?>
        <table class="table table-bordered">
            <thead>
                <tr class="bg-light">
                    <th style="width: 15%;" class="text-center">COMPONENT</th>
                    <th style="width: 50%;">CRITERIA</th>
                    <th style="width: 5%;">ACTION</th>
                    <th style="width: 30%;" class="text-center">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checklistComponentTemplates as $i => $component) : ?>
                    <tr>
                        <td rowspan=<?= $component->getCriteriaTemplatesCount() + 1 ?> class="align-middle text-center"><?= isset($component->component) ? $component->component->name : "Other components" ?></td>
                    </tr>
                    <?php foreach ($component->criteriaTemplates as $j => $criteria) : ?>
                        <?= Html::activeHiddenInput($checklistCriterias[$i][$j], "[{$i}][{$j}]equipment_component_id", ['value' => $component->equipment_component_id]); ?>
                        <?= Html::activeHiddenInput($checklistCriterias[$i][$j], "[{$i}][{$j}]component_name", ['value' => isset($component->component) ? $component->component->name : null]); ?>
                        <?= Html::activeHiddenInput($checklistCriterias[$i][$j], "[{$i}][{$j}]criteria", ['value' => $criteria->description]); ?>
                        <tr>
                            <td><?= $criteria->description ?></td>
                            <td>
                                <?= $form->field($checklistCriterias[$i][$j], "[{$i}][{$j}]result")->widget(SwitchInput::class, [
                                    'pluginOptions' => [
                                        'size' => 'small',
                                        'onText' => 'Yes',
                                        'offText' => 'No',
                                    ]
                                ])->label(false) ?>
                            </td>
                            <td>
                                <?= $form->field($checklistCriterias[$i][$j], "[{$i}][{$j}]remarks")->textarea(['rows' => 3])->label(false) ?>
                            </td>
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