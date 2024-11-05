<?php

/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\FicEquipment */

$this->title = 'Update Fic Equipment: ' . $model->equipment->model;
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->equipment->model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
            'equipments' => $equipments
        ]) ?>
    </div>
</div>