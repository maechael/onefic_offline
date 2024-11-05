<?php

use yii\db\Migration;

/**
 * Class m221122_085526_add_global_id_to_equipment_issue_repair_table
 */
class m221122_085526_add_global_id_to_equipment_issue_repair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_issue_repair}}', 'global_id', $this->string()->notNull()->after('id'));
        $this->createIndex('idx-equipment_issue_repair-global_id', '{{%equipment_issue_repair}}', 'global_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-equipment_issue_repair-global_id', '{{%equipment_issue_repair}}');
        $this->dropColumn('{{%equipment_issue_repair}}', 'global_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221122_085526_add_global_id_to_equipment_issue_repair_table cannot be reverted.\n";

        return false;
    }
    */
}
