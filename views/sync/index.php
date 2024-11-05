<?php

use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<h1 class="jumbotron">Test Sync</h1>
<a id='location-sync' href="location-sync" class="btn btn-app btn-sync"><i class="fas fa-globe"></i> Location </a>
<a id='fic-sync' href="fic-sync" class="btn btn-app btn-sync"><i class="fas fa-warehouse"></i> FIC </a>
<a id='media-sync' href="media-sync" class="btn btn-app btn-sync"><i class="fas fa-play"></i> Media </a>
<a id='sub-equipment-sync' href="sub-equipment-sync" class="btn btn-app btn-sync"><i class="fas fa-toolbox"></i> Sub Equipment </a>
<a id='equipment-sync' href="equipment-sync" class="btn btn-app btn-sync"><i class="fas fa-toolbox"></i> Equipment </a>
<a id='supplier-sync' href="supplier-sync" class="btn btn-app btn-sync"><i class="fas fa-boxes"></i> Supplier </a>
<hr>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">*insert title here</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Target</th>
                    <th>Source</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sync_map as $target => $source) : ?>
                    <tr>
                        <td><?= $target ?></td>
                        <td><?= $source ?></td>
                        <td>
                            <?= Html::button('sync', [
                                'class' => 'btn btn-info btn-sm per-table-sync',
                                'data' => [
                                    'source' => $source,
                                    'target' => $target,
                                    'url' => Url::to('sync-table')
                                ]
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$this->registerJs(<<<JS
    $('.btn-sync').on('click', e => {
        e.preventDefault();
        let button = $(e.currentTarget);
        button.toggleClass('disabled', true);

        $.ajax({
            type: 'GET',
            url: button.attr('href')
        }).done(data => {
            if(data.success){
                button.toggleClass('disabled', false);
            } else {
                console.log(data.message);
                button.toggleClass('disabled', false);
            }
        }).fail(() => {
            button.toggleClass('disabled', false);
        });
    });

    $('.per-table-sync').on('click', e => {
        let button = $(e.currentTarget);
        button.toggleClass('disabled', true);
        $.ajax({
            type: 'POST',
            url: button.data('url'),
            data: {source: button.data('source'), target: button.data('target')}
        }).done(data => {
            if(data.success){
                button.toggleClass('disabled', false);
            } else {
                console.log(data.message);
                button.toggleClass('disabled', false);
            }
        }).fail(() => {
            button.toggleClass('disabled', false);
        });
    });
JS);
