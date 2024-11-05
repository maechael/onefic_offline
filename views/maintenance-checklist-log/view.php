<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use app\models\Fic;

/**
 * @var yii\web\View $this
 * @var app\models\MaintenanceChecklistLog $checklistLog
 * @var app\models\FicEquipment $ficEquipment
 */

$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['fic-equipment/index']];
$this->params['breadcrumbs'][] = ['label' => $ficEquipment->equipment->model, 'url' => ['fic-equipment/view', 'id' => $ficEquipment->id]];
$this->params['breadcrumbs'][] = ['label' => 'Checklist Logs', 'url' => ['fic-equipment/checkist']];
$this->params['breadcrumbs'][] = 'Check list view';
\yii\web\YiiAsset::register($this);
?>
<div class="maintenance-checklist-log-view">

    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $checklistLog,
        'attributes' => [
            [
                'group' => true,
                'label' => '<h4>Regional Food Innovation Center Equipment Assessment Tool</h4>',
                'rowOptions' => [
                    'class' => 'text-center  table-info'
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'fic',
                        'label' => 'Host Institution',
                        'value' => function ($form, $widget) {
                            return $widget->model->fic->suc;
                        },
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'fic',
                        'label' => 'Region',
                        'value' => function ($form, $widget) {
                            return $widget->model->fic->region->name;
                        },
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'accomplished_by_name',
                        'label' => 'Accomplished by',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'endorsed_by_name',
                        'label' => 'Endorsed by',
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'accomplished_by_designation',
                        'label' => 'Designation',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'endorsed_by_designation',
                        'label' => 'Designation',
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'accomplished_by_office',
                        'label' => 'Office',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'endorsed_by_office',
                        'label' => 'Office',
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
        ],
    ]) ?>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr class="table-info">
                <th class="text-center">COMPONENT</th>
                <th>CRITERIA</th>
                <th>YES</th>
                <th>NO</th>
                <th class="text-center">REMARKS</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($indexedCriterias as $i => $criterias) : ?>
                <tr>
                    <td class='td-criteria' rowspan=<?= count($criterias) + 1 ?> class="align-middle text-center" style="border-top:80px;"><?= $i ?></td>
                </tr>
                <?php foreach ($criterias as $j => $criteria) : ?>
                    <tr>
                        <td><?= $criteria->criteria ?></td>
                        <td class="text-center"><?= $criteria->result ? '✓' : '' ?></td>
                        <td class="text-center"><?= !$criteria->result ? '✓' : '' ?></td>
                        <td class="text-center"><?= $criteria->remarks ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>


</div>

<?= Html::a('Update', ['update-checklist', 'id' => $checklistLog->id], ['class' => 'btn btn-primary']) ?>