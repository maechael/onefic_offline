<?php

use app\models\User;
use mdm\admin\models\AuthItem;
use yii\db\Migration;
use yii\rbac\Item;

/**
 * Class m220921_035431_initial_permission_seed
 */
class m220921_035431_initial_permission_seed extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        // $authItem = new AuthItem();
        // $authItem->name = 'P-Admin-Admin__All';
        // $authItem->type = Item::TYPE_PERMISSION;
        // $authItem->description = 'Admin permission to create permission';
        $adminPermission = $auth->createPermission('P-Admin-Admin__All');
        $adminPermission->description = 'Admin permission to manage RBAC';
        $auth->add($adminPermission);

        $authItem = new AuthItem();
        $authItem->name = '/admin/*';
        $authItem->type = Item::TYPE_PERMISSION;

        $auth->addChild($adminPermission, $authItem);

        $user = User::findOne(['username' => 'fic_admin2023']);
        $auth->assign($adminPermission, $user->id);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220921_035431_initial_permission_seed cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220921_035431_initial_permission_seed cannot be reverted.\n";

        return false;
    }
    */
}
