<?php
$totalParts = $model->getMaintenanceLogComponentParts()->count();
$totalInspected = $model->getMaintenanceLogComponentParts()->where(['isInspected' => 1])->count();
$totalOperational = $model->getMaintenanceLogComponentParts()->where(['isOperational' => 1])->count();
$totalInspectedPercentage = $totalParts > 0 ? round(($totalInspected / $totalParts) * 100, 2) : 0;
$totalOperationalPercentage = $totalParts > 0 ? round(($totalOperational / $totalParts) * 100, 2) : 0;
?>
<label>Remarks:</label>
<?= $model->conclusion_recommendation ?>
<label>Inspection %</label>
<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: <?= $totalInspectedPercentage ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<label>Operational %</label>
<div class="progress">
    <div class="progress-bar" role="progressbar" style="width: <?= $totalOperationalPercentage ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
</div>