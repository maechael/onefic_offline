<?php


use Mpdf\Tag\Div;

$totalParts = $model->getMaintenanceLogComponentParts()->count();
$totalInspected = $model->getMaintenanceLogComponentParts()->where(['isInspected' => 1])->count();
$totalOperational = $model->getMaintenanceLogComponentParts()->where(['isOperational' => 1])->count();
$totalInspectedPercentage = $totalParts > 0 ? round(($totalInspected / $totalParts) * 100, 2) : 0;
$totalOperationalPercentage = $totalParts > 0 ? round(($totalOperational / $totalParts) * 100, 2) : 0;

$this->registerJsVar('modelId', $model->id);
$this->registerJsVar('totalInspectedPercentage', $totalInspectedPercentage);
?>

<div class="card">
    <div class="card-body">
        <div class="d-flex">
            <h6 class="mb-0 secondary">Date Inspected: <?= $model->maintenance_date ?></h6>
            <small class="text-muted ml-auto">Duration: <?= "{$model->time_started} - {$model->time_ended}" ?></small>
        </div>
        <div class="row pt-4">
            <div class="col-6">
                <div class="d-flex">
                    <?php if (empty($model->conlusion_recommendation)) : ?>
                        <p class=" text-muted text-sm">Remarks:</p>
                        <div class="row pt-3 pl-2">
                            <div class="col 3">
                                <?= $model->conclusion_recommendation ?>
                            </div>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex flex-row-reverse">
                    <div class="p-4">
                        <?php
                        echo softcommerce\knob\Knob::widget(

                            [

                                'name' => 'animated_knob_with_icon',
                                'value' => $totalInspectedPercentage,
                                'icon' => '<span class="glyphicon glyphicon-flash"></span>',
                                'options' => [
                                    'data-min' => '0',
                                    'data-max' => '100',
                                    'data-width' => '100',
                                    'data-height' => '100',
                                ],
                                'knobOptions' => [
                                    'readOnly' => true,
                                    'thickness' => '.25',
                                    'dynamicDraw' => true,
                                    'fgColor' => '#9fc569',
                                ],
                            ]
                        );
                        ?>
                    </div>
                    <div class="p-4">
                        <?php
                        echo softcommerce\knob\Knob::widget(

                            [

                                'name' => 'animated_knob_with_icon',
                                'value' => $totalOperationalPercentage,
                                'icon' => '<span class="glyphicon glyphicon-flash"></span>',
                                'options' => [
                                    'data-min' => '0',
                                    'data-max' => '100',
                                    'data-width' => '100',
                                    'data-height' => '100',
                                ],
                                'knobOptions' => [
                                    'readOnly' => true,
                                    'thickness' => '.25',
                                    'dynamicDraw' => true,
                                    'fgColor' => '#9fc569',
                                ],
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class=" d-flex">
        <small class="text-muted">
            Inspected by:<?= $model->inspected_checked_by ?>
        </small>
        <div class="ml-auto">
            <small class="text-muted">
                Noted by: <?= $model->noted_by ?>
            </small>
        </div>
    </div>
</div>




<?php
$this->registerJs(<<<JS
    const numb = $('#modelId');
    let counter = 0;
    setInterval(() => {
        if(counter == 100){
            clearInterval();
        }else{
            counter+=1;
            numb.textContent = counter + "%";
        }
    }, 80);
JS);
