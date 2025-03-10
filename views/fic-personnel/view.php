<?php

use kartik\detail\DetailView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\UserProfile */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$name = "{$model->lastname}, {$model->firstname} {$model->middlename}.";
?>

<div class="container-fluid">
    <div class="card">

        <div class="row">
            <div class="col-md-12">

                <?= DetailView::widget([
                    'model' => $model,
                    'striped' => false,
                    'attributes' => [
                        [
                            'group' => true,
                            'label' => "User's Information",
                            'valueColOptions' => ['style' => 'width:20%'],
                            'rowOptions' => [
                                'class' => 'table-info text-center '
                            ]
                        ],
                        [
                            'columns' => [
                                [

                                    'label' => 'Name',
                                    'value' => ucwords($name),
                                    'valueColOptions' => ['style' => 'width:80%']

                                ],

                            ]
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => '',
                                    'label' => 'Designation',
                                    'value' => $model->designation->name,
                                    'valueColOptions' => ['style' => 'width:30%']

                                ],
                                [
                                    'attribute' => '',
                                    'label' => 'FIC Affilitation',
                                    'value' => $model->fic->name,
                                    'valueColOptions' => ['style' => 'width:30%']
                                ]

                            ]
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => 'created_at',
                                    'valueColOptions' => ['style' => 'width:30%']

                                ],

                                [
                                    'attribute' => 'updated_at',
                                    'valueColOptions' => ['style' => 'width:30%']
                                ]

                            ]
                        ],
                    ],
                ]) ?>
            </div>
            <!--.col-md-12-->
        </div>
        <!--.row-->
    </div>
    <!--.card-->
</div>