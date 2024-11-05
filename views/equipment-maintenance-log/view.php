<?php

use app\models\Equipment;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ListView;

$formatter = \Yii::$app->formatter;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => '../fic-equipment/index'];
$this->params['breadcrumbs'][] = ['label' => "{$maintainanceLog->ficEquipment->equipment->model}", 'url' => Url::to(['fic-equipment/view', 'id' => $maintainanceLog->ficEquipment->id])];
$this->params['breadcrumbs'][] = ['label' => "Maintenance List", 'url' => Url::to(['equipment-maintenance-log/maintenance-list', 'fic_equipment_id' => $maintainanceLog->ficEquipment->id])];
$this->params['breadcrumbs'][] = 'Maintenance Detail';

echo DetailView::widget([
    'model' => $maintainanceLog,
    'attributes' => [
        [
            'group' => true,
            'label' => "Maintanance Log",
            'valueColOptions' => ['style' => 'width:30%'],
            'rowOptions' => [
                'class' => 'table-info'
            ]
        ],
        [
            'columns' => [
                [
                    'attribute' => '',
                    'label' => 'Inspected by',
                    'value' => $maintainanceLog->inspected_checked_by,
                    'valueColOptions' => ['style' => 'width:30%']

                ],
                [
                    'attribute' => '',
                    'label' => 'Noted by',
                    'value' => $maintainanceLog->noted_by,
                    'valueColOptions' => ['style' => 'width:30%']

                ]
            ]
        ],

        [
            'columns' => [
                [
                    'attribute' => 'equipment',
                    'value' => $maintainanceLog->equipment->model,
                    'valueColOptions' => ['style' => 'width:30%']

                ],
                [
                    'attribute' => '',
                    'label' => 'Maintainance Date',
                    'value' => $maintainanceLog->maintenance_date,
                    'valueColOptions' => ['style' => 'width:30%']

                ]
            ]
        ],
        [
            'columns' => [
                [
                    'attribute' => '',
                    'label' => 'Time started',
                    'value' => $maintainanceLog->time_started,
                    'valueColOptions' => ['style' => 'width:30%']

                ],
                [
                    'attribute' => '',
                    'label' => 'Time ended',
                    'value' => $maintainanceLog->time_ended,
                    'valueColOptions' => ['style' => 'width:30%']
                ]
            ]
        ],
        [
            'columns' => [
                [
                    'attribute' => '',
                    'label' => 'Conclusion/Reccommendation',
                    'value' => $maintainanceLog->conclusion_recommendation,
                    'format' => 'raw',
                    // 'valueColOptions' => ['style' => 'width:10%']

                ]
            ]
        ],

    ],
]);
?>

<div class="card card-primary mt-2">
    <div class="card-header">
        <div class="card-title">
            <h5 class="mb-0">Repair/Rehabilitation Activity</h5>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Component Part</th>
                    <th>Inspected Percentage</th>
                    <th>Operational Percentage</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($groupedParts as $key => $grouped) : ?>
                    <tr data-widget="expandable-table" aria-expanded="false">
                        <td><?= $grouped[0]->equipmentComponent->component->name; ?></td>
                        <td>
                            <?php
                            $inspectedCount = $maintainanceLog->getInspectedCount($grouped[0]->equipment_component_id);
                            $partPerComponentCount = count($grouped);
                            $inspectedPercentage = $inspectedCount / $partPerComponentCount * 100;
                            $inspectedPercentageOutput = $inspectedCount / $partPerComponentCount;

                            if ($inspectedPercentage <= 50) {
                                echo  "<div class='progress progress-lg progress-striped active'>
                                      <div class='progress-bar bg-danger' style='width: {$formatter->asPercent($inspectedPercentageOutput)}'>{$formatter->asPercent($inspectedPercentageOutput)}</div>
                                   </div>";
                            }
                            if ($inspectedPercentage > 50 && $inspectedPercentage <= 90) {
                                echo  "<div class='progress progress-lg progress-striped active'>
                                      <div class='progress-bar bg-warning' style='width: {$formatter->asPercent($inspectedPercentageOutput)}'>{$formatter->asPercent($inspectedPercentageOutput)}</div>
                                   </div>";
                            }
                            if ($inspectedPercentage > 90) {
                                echo  "<div class='progress progress-lg progress-striped active'>
                                      <div class='progress-bar bg-success' style='width: {$formatter->asPercent($inspectedPercentageOutput)}'>{$formatter->asPercent($inspectedPercentageOutput)}</div>
                                   </div>";
                            }

                            ?>
                        </td>
                        <td>
                            <?php
                            $operationalCount = $maintainanceLog->getOperationalCount($grouped[0]->equipment_component_id);
                            $partPerComponentCount = count($grouped);
                            $operationalPercentage = $operationalCount / $partPerComponentCount * 100;
                            $operationalPercentageOutput = $operationalCount / $partPerComponentCount;
                            if ($operationalPercentage <= 50) {
                                echo  "<div class='progress progress-lg progress-striped active'>
                                      <div class='progress-bar bg-danger' style='width: {$formatter->asPercent($operationalPercentageOutput)}'>{$formatter->asPercent($operationalPercentageOutput)}</div>
                                   </div>";
                            }
                            if ($operationalPercentage > 50 && $operationalPercentage <= 90) {
                                echo  "<div class='progress progress-lg progress-striped active'>
                                      <div class='progress-bar bg-warning' style='width: {$formatter->asPercent($operationalPercentageOutput)}'>{$formatter->asPercent($operationalPercentageOutput)}</div>
                                   </div>";
                            }
                            if ($operationalPercentage > 90) {
                                echo  "<div class='progress progress-lg progress-striped active'>
                                      <div class='progress-bar bg-success' style='width: {$formatter->asPercent($operationalPercentageOutput)}'>{$formatter->asPercent($operationalPercentageOutput)}</div>
                                   </div>";
                            }

                            ?>
                        </td>
                    </tr>
                    <tr class="expandable-body d-none">
                        <td colspan="4">
                            <div class="card-columns">
                                <?php foreach ($grouped as $part) : ?>
                                    <div class="card callout callout-info">
                                        <?= $part->equipmentComponentPart->part->name ?>
                                        <?php
                                        $inspectedClass = $part->isInspected == 1 ? 'success' : 'danger';
                                        $inspectedText = $part->isInspected == 1 ? 'inspected' : 'nope';
                                        echo " <span class='badge bg-{$inspectedClass}'>{$inspectedText}</span>";
                                        ?>
                                        <?php
                                        $operationalClass = $part->isOperational == 1 ? 'success' : 'danger';
                                        $operationalText = $part->isOperational == 1 ? 'operational' : 'nope';
                                        echo " <span class='badge bg-{$operationalClass}'>{$operationalText}</span>";
                                        ?>
                                        <?php
                                        if (!empty($part->remarks)) {
                                            echo "<footer class='blockquote-footer'> {$part->remarks}</footer>";
                                        }
                                        ?>

                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>