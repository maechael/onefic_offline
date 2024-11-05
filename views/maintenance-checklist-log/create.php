<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MaintenanceChecklistLog $model */

$this->title = 'Create Maintenance Checklist Log';
$this->params['breadcrumbs'][] = ['label' => 'Maintenance Checklist Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="maintenance-checklist-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
