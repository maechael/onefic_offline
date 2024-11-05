<?php

/**
 * @var $checklistLog app\models\MaintenanceChecklistLog
 * @var $fic app\models\Fic
 * @var $ficEquipment app\models\FicEquipment
 * @var $indexedCriterias app\models\ChecklistCriteria[] as an indexed data
 */
?>
<h4 style="text-align:center"><b>Regional Food Innovation Center Equipment Assessment Tool</b></h4>
<br>
<label for=""><b>REGION:</b> </label><?= $fic->region->name ?>
<br>
<label for=""><b> Host Institution:</b> </label><?= $fic->suc ?>
<br><br>
<p><b>INSTRUCTIONS: </b>Check (✓) appropriate boxes based on the criteria indicated for each component. Write down <b>specific details</b> on the REMARKS column. This form shall be accomplished by a <b>technical person/engineer</b> available in the workplace.</p>
<br>
<h5 style="text-align:center;"><b>FIC Equipment: <?= $ficEquipment->equipment->model ?></b></h5>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">COMPONENT</th>
            <th>CRITERIA</th>
            <th>YES</th>
            <th>NO</th>
            <th class="text-center">REMARKS</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($indexedCriterias as $i => $criterias) : ?>
            <tr>
                <td class='td-criteria' rowspan=<?= count($criterias) + 1 ?> class="align-middle text-center" style="border-top:80px;"><?= $i ?></td>
            </tr>
            <?php foreach ($criterias as $j => $criteria) : ?>
                <tr>
                    <td><?= $criteria->criteria ?></td>
                    <td class="text-center"><?= $criteria->result ? '✓' : '' ?></td>
                    <td class="text-center"><?= !$criteria->result ? '✓' : '' ?></td>
                    <td class="text-center"><?= $criteria->remarks ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<br>



<table class="table table-borderless">


    <tr>
        <td>
            <h4>Accomplished by:</h4>
            <br>
            <br>
            <h5><b>Name/Signature:</b> <?= $checklistLog->accomplished_by_name ?></h5>

        </td>
        <td>
            <h4>Endrosed by:</h4>
            <br>
            <br>
            <h5><b>Name/Signature:</b> <?= $checklistLog->endorsed_by_name ?></h5>
        </td>
    </tr>
    <tr>
        <td><b>Designation:</b> <?= $checklistLog->accomplished_by_designation ?></td>
        <td><b>Designation:</b> <?= $checklistLog->endorsed_by_designation ?></td>
    </tr>
    <tr>
        <td><b>Office:</b> <?= $checklistLog->accomplished_by_office ?></td>
        <td><b>Office:</b> <?= $checklistLog->endorsed_by_office ?></td>
    </tr>
    <tr>
        <td><b>Date:</b> <?= $checklistLog->accomplished_by_date ?></td>
        <td><b>Date:</b> <?= $checklistLog->endorsed_by_date ?></td>
    </tr>



</table>