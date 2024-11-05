<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MaintenanceChecklistLog $model */

$this->title = 'Update Maintenance Checklist Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Maintenance Checklist Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="maintenance-checklist-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
