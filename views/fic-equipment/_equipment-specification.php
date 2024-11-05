<?php

?>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
        <a href="#tab-content-specification" class="nav-link active" data-toggle="pill" role="tab">Specification</a>
    </li>
    <li class="nav-item">
        <a href="#tab-content-component" class="nav-link" data-toggle="pill" role="tab">Components & Parts</a>
    </li>
    <li class="nav-item">
        <a href="#tab-content-tech-service" class="nav-link" data-toggle="pill" role="tab">Tech Service</a>
    </li>
</ul>
<div class="card">
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tab-content-specification">
                <?php if (isset($model->equipmentSpecs) && $model->getEquipmentSpecs()->count() > 0) : ?>
                    <div class="d-flex flex-wrap">
                        <?php foreach ($model->equipmentSpecs as $spec) : ?>
                            <!-- <div class="bd-highlight"><?= $spec->specKey->name ?>: <?= $spec->value ?></div> -->
                            <table class="table table-bordered m-0">
                                <tr>
                                    <td class="table-secondary col-3"><?= $spec->specKey->name ?></td>
                                    <td><?= $spec->value ?></td>
                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="tab-content-component">
                <div class="card-columns">
                    <?php foreach ($model->equipmentComponents as $component) : ?>
                        <div class="card">
                            <div class="card-header text-center bg-light"><?= $component->component->name ?></div>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($component->equipmentComponentParts as $part) : ?>
                                    <li class="list-group-item d-flex">
                                        <?= $part->part->name ?>
                                        <!-- <span class="badge ml-auto">operational</span> -->
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
            <div class="tab-pane fade" id="tab-content-tech-service">
                <?php foreach ($model->techServices as $techService) : ?>
                    <button class="btn btn-info"><?= $techService->name ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>