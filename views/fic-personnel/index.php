<?php

use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\helpers\Html;
use yii\bootstrap4\Modal;


use function PHPUnit\Framework\isNull;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ficModule\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$fic = Yii::$app->user->identity->userProfile->fic;
$this->title = isset($fic) ? $fic->name : '' . " Personnels";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            'firstname',
            'lastname',
            'middlename',
            [
                'attribute' => 'designation',
                'value' => 'designation.description',
            ],
            //'created_at',
            //'updated_at',

            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
                'dropdownMenu' => ['class' => 'text-left'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-pencil-alt"></span>', ['update-personnel', 'id' => $model->id],);
                    }
                ]
            ],

        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficPersonnelGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fas fa-users"></i> Personnels',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="fas fa-plus"></i>', ['signup'], ['class' => 'btn btn-sm btn-default', 'title' => 'Add Personnel']) .
                    Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
            ],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]); ?>

</div>
<?php
echo $this->render('_create_personnel', [
    'affiliation' => $affiliation,
    'designation' => $designation,
    'model' => $model
]);
?>