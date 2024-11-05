<?php

use app\assets\FilterMultiSelectAsset;
use app\models\Equipment;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Supplier';

// FilterMultiSelectAsset::register($this);
?>
<div class="container-fluid">

    <?php echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'organization_name',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->organization_name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw'
            ],
            'form_of_organization',
            'contact_person',
            'email:email',
            //'telNumber',
            //'region_id',
            //'province_id',
            //'municipality_city_id',
            //'address',
            //'is_philgeps_registered',
            'certificate_ref_num',
            //'approval_status',
            //'organization_status',
            //'created_at',
            //'updated_at',

            // ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficEquipmentGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fas fa-boxes"></i> Suppliers',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            // [
            //     'content' => Html::button('Add Equipment', ['data-toggle' => 'modal', 'data-target' => '#modal-create-fic-equipment', 'class' => 'btn btn-success btn-sm'])
            // ],
            '{export}',
            '{toggleData}'
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]); ?>

</div>
<?php
// $this->registerJs($this->render('_script.js'));
