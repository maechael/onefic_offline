<?php

use app\models\EquipmentIssue;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipmentIssueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var ficEquipment app\models\FicEquipment */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $ficEquipment->equipment->model, 'url' => ['view', 'id' => $ficEquipment->id]];
$this->params['breadcrumbs'][] = 'Issues';

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        // ['class' => SerialColumn::class],
        [
            'attribute' => 'title',
            // 'label' => 'Concern',
            'value' => function ($model) {
                $badge = $model->recentRepairCount > 0 ? "<span class='badge badge-warning'>{$model->recentRepairCount}</span>" : '';
                return "{$model->title}" . $badge;
            },
            'format' => 'raw'
        ],
        'description:raw',
        [
            'attribute' => 'status',
            'value' => function ($model, $key, $index, $column) {
                return $model->statusDisplay;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => [
                EquipmentIssue::STATUS_OPEN => 'Open',
                EquipmentIssue::STATUS_CLOSED => 'Closed'
            ],
            'filterWidgetOptions' => [
                'theme' => Select2::THEME_BOOTSTRAP,
                'hideSearch' => true,
            ],

        ],
        'created_at',
        [
            'class' => ActionColumn::class,
            'buttons' => [
                'issue' => function ($url, $model) {
                    return Html::a('<span class="fas fa-eye"></span>', $url);
                }
            ],
            'template' => '{issue}'
        ],
    ],
    'responsive' => true,
    'hover' => true,
    'condensed' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'id' => 'equipment-issues-grid'
        ]
    ],
    'floatHeader' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<i class="fas fa-clipboard"></i> Issues',
        'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
    ],
    'toolbar' => [
        [
            'content' => Html::button('<i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create', 'class' => 'btn btn-default btn-sm']) .
                Html::a('<i class="fas fa-redo-alt"></i>', ['', 'fic_equipment_id' => $ficEquipment->id], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                '{toggleData}' .
                '{export}'
        ],
    ],
    'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
    'exportContainer' => ['class' => 'btn-group-sm ml-1']
]) ?>
<?php

//..Create Issue Modal
echo $this->render('_create_issue', [
    'issue' => new EquipmentIssue(),
    'ficEquipment' => $ficEquipment,
    'fic_equipment_id' => $ficEquipment->id,
    'parts' => $ficEquipment->parts,
    'components' => $ficEquipment->components
]);
