<?php

use yii\db\Migration;

/**
 * Class m230203_100106_alter_equipment_issue_table
 */
class m230203_100106_alter_equipment_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%equipment_issue}}', 'global_id', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%equipment_issue}}', 'global_id', $this->string()->notNull());
    }
}
