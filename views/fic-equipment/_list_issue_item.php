<?php

use yii\helpers\Html;

$icon = $model->status >= 1 ? "times" : "check";
?>
<li class="list-group-item">
    <div class="d-flex w-100 justify-content-between">
        <div class="d-flex align-items-center">
            <?= "<i class='fas fa-{$icon}-circle fa-fw'></i>" ?>
            <!-- <h5 class="mb-0"><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id], ['data-pjax' => 0]) ?></h5> -->
            <h5 class="mb-0"><?= Html::a(Html::encode($model->title), ['issue', 'id' => $model->id]) ?></h5>
        </div>
        <small><?= Yii::$app->formatter->asDate($model->created_at) ?></small>
    </div>
    <p class="mb-1"><?= $model->description ?></p>
</li>