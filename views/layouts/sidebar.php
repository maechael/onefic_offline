<?php

use hail812\adminlte\widgets\Menu;
use mdm\admin\components\Helper;
use mdm\admin\components\MenuHelper;
use yii\helpers\ArrayHelper;

$menuItems = [
    ['label' => 'FIC', 'url' => ['/fic/index'], 'icon' => 'warehouse'],
    [
        'label' => 'Equipment',
        'icon' => 'toolbox',
        'items' => [
            ['label' => 'Equipment', 'url' => ['/fic-equipment/index'], 'iconStyle' => 'fas', 'icon' => 'caret-right'],
        ],
    ],


    // ['label' => 'Products', 'url' => ['/fic-module/fic-personnel/index'], 'icon' => 'box-open'],
    ['label' => 'Supplier', 'url' => ['/supplier/index'], 'icon' => 'boxes'],
    ['label' => 'Fabricators', 'url' => ['/fic-module/fic-personnel/index'], 'icon' => 'truck-loading'],
    // ['label' => 'Facility', 'url' => ['/facility/index'], 'icon' => 'laptop-house'],
    // ['label' => 'Service', 'url' => ['/service/index'], 'icon' => 'hand-holding-water'],

    // ['label' => 'User Administration', 'header' => true],
    ['label' => 'Users', 'url' => ['/user-profile/index'], 'icon' => 'users'],
    ['label' => 'Tech-Service', 'url' => ['/fic-tech-service/index'], 'icon' => 'handshake'],
];

$userItems = [
    ['label' => 'Personnels', 'url' => ['/fic-personnel/index'], 'icon' => 'users'],
    // ['label' => 'Equipment Maintenance Log', 'url' => ['/equipment-maintenance-log/index'], 'icon' => 'users'],

];

$securityItems = [
    ['label' => 'Routes', 'url' => ['/admin/route/'], 'icon' => 'route'],
    ['label' => 'Permissions', 'url' => ['/admin/permission/'], 'icon' => 'user-edit'],
    ['label' => 'Assignments', 'url' => ['/admin/assignment/'], 'icon' => 'address-book'],
    ['label' => 'Roles', 'url' => ['/admin/role/'], 'icon' => 'user-tag'],

    // ['label' => 'Menu', 'url' => ['/admin/menu/'], 'icon' => 'bars'],

    ['label' => 'Rules', 'url' => ['/admin/rule/'], 'icon' => 'scroll'],
];

$menuItems = Helper::filter($menuItems);
$userItems = Helper::filter($userItems);
$securityItems = Helper::filter($securityItems);
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="oneFIC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= Yii::$app->name ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?= Menu::widget([
                'items' => [
                    ...$menuItems,
                    ['label' => 'User Administration', 'header' => true],
                    ...$userItems,
                    ['label' => 'Security', 'header' => true],
                    ...$securityItems
                ]
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>