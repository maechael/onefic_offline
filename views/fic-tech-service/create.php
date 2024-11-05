<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\FicTechService $model */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fic Tech Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="fic-tech-service-create">

    <?= $this->render('_form', [
        'model' => $model,
        'equipments' => $equipments
    ]) ?>

</div>