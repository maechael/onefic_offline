<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_issue_repair}}`.
 */
class m221019_093509_create_equipment_issue_repair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_issue_repair}}', [
            'id' => $this->primaryKey(),
            'equipment_issue_id' => $this->integer()->notNull(),
            'repair_activity' => $this->text()->notNull(),
            'performed_by' => $this->string(128)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}', 'equipment_issue_id');
        $this->addForeignKey('fk-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}', 'equipment_issue_id', '{{%equipment_issue}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}');
        $this->dropIndex('idx-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}');

        $this->dropTable('{{%equipment_issue_repair}}');
    }
}
