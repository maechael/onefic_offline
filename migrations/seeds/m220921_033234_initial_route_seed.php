<?php

use mdm\admin\models\Route;
use yii\db\Migration;

/**
 * Class m220921_033234_initial_route_seed
 */
class m220921_033234_initial_route_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $route = new Route();
        $route->addNew(['/admin/*', '/admin/menu/index']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220921_033234_initial_route_seed cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220921_033234_initial_route_seed cannot be reverted.\n";

        return false;
    }
    */
}
