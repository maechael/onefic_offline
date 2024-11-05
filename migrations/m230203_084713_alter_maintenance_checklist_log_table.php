<?php

use yii\db\Migration;

/**
 * Class m230203_084713_alter_maintenance_checklist_log_table
 */
class m230203_084713_alter_maintenance_checklist_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%maintenance_checklist_log}}', 'global_id', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%maintenance_checklist_log}}', 'global_id', $this->string()->notNull());
    }
}
