<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\FicTechService $model */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fic Tech Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fic-tech-service-update">

    <?= $this->render('_form', [
        'model' => $model,
        'equipments' => $equipments
    ]) ?>

</div>