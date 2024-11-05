<?php

/**
 * @var yii\web\View $this
 * @var array syncMap
 */

use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = '';
?>
<div class="init-view">
    <a href=<?= Url::to('sync-table') ?> class="btn btn-info btn-outline-dark btn-block btn-sync m-1">Sync</a>
    <table class="table table-striped table-bordered">
        <thead class="" style="background-color: #26ac9f;">
            <tr>
                <th>Target</th>
                <th>Source</th>
                <th>Status</th>


            </tr>
        </thead>
        <tbody>
            <?php foreach ($syncMap as $target => $source) : ?>
                <tr>
                    <td><?= $target ?></td>
                    <td><?= $source ?></td>
                    <td class="<?= $target ?> ">
                        pending
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$this->registerJsVar('syncMap', $syncMap);
$this->registerJs(<<<JS
     $('.btn-sync').on('click', async e => {
           e.preventDefault();
           let button = $(e.currentTarget);
           button.toggleClass('disabled', true);
           let divElement = $('<div>').addClass("spinner-border spinner-border-sm");
           for (const [key, value] of Object.entries(syncMap)) {
               $('td.' + key).text(' ').append(divElement);
               await $.ajax({
                   type: 'POST',
                   url: button.attr('href'),
                   data: { target: key, source: value }
               }).done(data => {
                   if (data.success) {
                      $('td.' + key).text('completed');
                  } else {
                    console.log('test');
                     $('td.' + key).empty().text('failed');
                    //    $('td.' + key);
                   }
               }).fail(() => {
                   $('td.' + key).text('failed');
               });
           }
   
           button.toggleClass('disabled', false);
      });
JS);
