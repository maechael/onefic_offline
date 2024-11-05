<?php

use yii\bootstrap4\Modal;
use app\models\Equipment;


?>
<?php Modal::begin([
    'id' => 'modal-more',
    'title' => 'Add Products',
    'size' => 'modal-md',
    'centerVertical' => true,
    'headerOptions' => ['class' => 'bg-info']
]);

?>

<div id="moreId"> </div>



<?php Modal::end();
?>
<style>
    #modal-more {
        margin: 10px 0;
    }
</style>