<?php

use app\models\FicTechService;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\FicTechServiceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'FIC Tech Services';
?>
<div class="fic-tech-service-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            // 'fic_id',
            [
                'attribute' => 'equipment',
                'value' => function ($model) {
                    return $model->equipment->model;
                }
            ],

            [
                'attribute' => 'techService',
                'value' => function ($model) {
                    return $model->techService->name;
                }
            ],

            'charging_type',
            'charging_fee',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, FicTechService $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficTechServiceGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-hands-helping"></i> Tech Services',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => Html::button('<i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-tech-service', 'class' => 'btn btn-default btn-sm', 'title' => 'Create Tech Service']) .
                    Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
            ],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']

    ]); ?>

</div>
<?= $this->render('_create_tech_service', ['model' => new FicTechService(), 'equipments' => $equipments]) ?>