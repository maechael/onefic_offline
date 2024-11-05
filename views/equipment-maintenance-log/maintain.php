<?php

use kartik\editors\Summernote;
use yii\bootstrap4\ActiveForm;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "";
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => Url::to('/fic-equipment/index')];
$this->params['breadcrumbs'][] = ['label' => $ficEquipment->equipment->model, 'url' => Url::to(['/fic-equipment/view', 'id' => $ficEquipment->id])];
$this->params['breadcrumbs'][] = "Maintenance";
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($maintenanceLogModel, 'fic_equipment_id')->hiddenInput()->label(false) ?>

<?= $form->field($maintenanceLogModel, 'maintenance_date')->input('date', ['class' => 'form-control']) ?>

<div class="row">
    <div class="col-6">
        <?= $form->field($maintenanceLogModel, 'time_started')->input('time', ['class' => 'form-control']) ?>
    </div>
    <div class="col-6">
        <?= $form->field($maintenanceLogModel, 'time_ended')->input('time', ['class' => 'form-control']) ?>
    </div>
</div>

<table class="table table-sm table-bordered table-hover">
    <thead class="text-center">
        <th></th>
        <th>Cleaned/Inspected</th>
        <th>Operational</th>
        <th>Remarks</th>
    </thead>
    <tbody>
        <?php foreach ($equipmentComponents as $iec => $equipmentComponent) : ?>
            <tr>
                <td class="font-weight-bold" colspan="4"><?= $equipmentComponent->component->name ?></td>
            </tr>
            <?php foreach ($equipmentComponent->equipmentComponentParts as $iecp => $equipmentComponentPart) : ?>
                <?= $form->field($logComponentParts[$iec][$iecp], "[{$iec}][{$iecp}]equipment_component_part_id")->hiddenInput()->label(false) ?>
                <?= $form->field($logComponentParts[$iec][$iecp], "[{$iec}][{$iecp}]equipment_component_id")->hiddenInput()->label(false) ?>
                <tr>
                    <td class="align-middle pl-3">
                        <?php $ctr = $iecp + 1; ?>
                        <?= "{$ctr}. {$equipmentComponentPart->part->name}" ?>
                    </td>
                    <td class="text-center align-middle">
                        <?= $form->field($logComponentParts[$iec][$iecp], "[{$iec}][{$iecp}]isInspected")->widget(SwitchInput::class, [
                            'pluginOptions' => [
                                'size' => 'small',
                                'onText' => 'Yes',
                                'offText' => 'No',
                            ]
                        ])->label(false) ?>
                    </td>
                    <td class="text-center align-middle">
                        <?= $form->field($logComponentParts[$iec][$iecp], "[{$iec}][{$iecp}]isOperational")->widget(SwitchInput::class, [
                            'pluginOptions' => [
                                'size' => 'small',
                                'onText' => 'Yes',
                                'offText' => 'No',
                            ]
                        ])->label(false) ?>
                    </td>
                    <td class="align-middle"><?= $form->field($logComponentParts[$iec][$iecp], "[{$iec}][{$iecp}]remarks")->textInput(['class' => 'form-control form-control-sm'])->label(false) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>

    </tbody>
</table>

<div class="row">
    <div class="col-6">
        <?= $form->field($maintenanceLogModel, 'inspected_checked_by')->textInput() ?>
    </div>
    <div class="col-6">
        <?= $form->field($maintenanceLogModel, 'noted_by')->textInput() ?>
    </div>
</div>

<?= $form->field($maintenanceLogModel, 'conclusion_recommendation')->widget(Summernote::class, [
    'useKrajeePresets' => true,
    'container' => [
        'class' => ''
    ]
]) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>