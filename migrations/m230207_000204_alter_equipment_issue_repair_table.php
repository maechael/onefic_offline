<?php

use yii\db\Migration;

/**
 * Class m230207_000204_alter_equipment_issue_repair_table
 */
class m230207_000204_alter_equipment_issue_repair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%equipment_issue_repair}}', 'global_id', $this->string()->null());
        $this->alterColumn('{{%equipment_issue_repair}}', 'equipment_issue_gid', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%equipment_issue_repair}}', 'global_id', $this->string()->notNull());
        $this->alterColumn('{{%equipment_issue_repair}}', 'equipment_issue_gid', $this->string()->notNull());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230207_000204_alter_equipment_issue_repair_table cannot be reverted.\n";

        return false;
    }
    */
}
