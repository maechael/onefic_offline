<?php
/* @var $this yii\web\View */

use app\assets\LeafletAsset;
use kartik\detail\DetailView;
use yii\helpers\Html;

$this->title = '';
$this->params['breadcrumbs'][] = $fic->name;

LeafletAsset::register($this);
?>

<div class="fic-view">
    <?= DetailView::widget([
        'model' => $fic,
        'attributes' => [
            [
                'group' => true,
                'label' => 'CONTACT INFORMATION',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'contact_person',
                    ],
                    [
                        'attribute' => 'email',
                    ],
                    [
                        'attribute' => 'contact_number',
                    ]
                ]
            ],
            [
                'group' => true,
                'label' => 'ADDRESS INFORMATION',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'region',
                        'value' => $fic->region->code,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'province',
                        'value' => $fic->province->name,
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'municipalityCity',
                        'value' => $fic->municipalityCity->name,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'address',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],

                ]
            ],
            [
                'group' => true,
                'label' => 'MAP LOCATION',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'attribute' => 'address',
                'label' => false,
                'labelColOptions' => ['class' => 'd-none'],
                'format' => 'raw',
                'value' => "<div id='map' style='height: 500px;'></div>"
            ]
        ],
        'mode' => DetailView::MODE_VIEW,
        'enableEditMode' => false,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => false,
        'hideIfEmpty' => false,
        'notSetIfEmpty' => true,
        'hAlign' => DetailView::ALIGN_RIGHT,
        'vAlign' => DetailView::ALIGN_MIDDLE,
        'panel' => [
            'type' => DetailView::TYPE_PRIMARY,
            'heading' => "<i class='fas fa-warehouse'></i> {$fic->name}"

        ],
    ]) ?>
</div>
<?php
$this->registerJsVar('long', $fic->isNewRecord ? 0 : (isset($fic->longitude) ? $fic->longitude : 0));
$this->registerJsVar('lat', $fic->isNewRecord ? 0 : (isset($fic->latitude) ? $fic->latitude : 0));
$this->registerJs(<<<JS
    var map = L.map('map', {
        dragging: true,
        zoomControl: true,
        scrollWheelZoom: false
    }).setView([lat, long], 12);
    // var geoLayer = L.geoJSON(geoFeatureCollection).addTo(map);
    var marker = L.marker([lat, long]);

    marker.addTo(map);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 3,
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
JS);
?>
<?php
// echo Html::a('Update', ['fic/update', 'id' => $fic->id], ['class' => 'btn btn-info btn-lg btn-block']) 
?>