<?php

use mdm\admin\models\Menu;
use yii\db\Migration;

/**
 * Class m220921_082310_initial_menu_seed
 */
class m220921_082310_initial_menu_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $menu = new Menu();;
        $menu->name = 'Menu';
        $menu->order = 1;
        $menu->route = '/admin/menu/index';
        $isValid = $menu->validate();
        if ($isValid)
            $menu->save(false);
        else
            return false;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220921_082310_initial_menu_seed cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220921_082310_initial_menu_seed cannot be reverted.\n";

        return false;
    }
    */
}
