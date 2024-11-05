<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_equipment_status_history}}`.
 */
class m221027_065838_create_fic_equipment_status_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_equipment_status_history}}', [
            'id' => $this->primaryKey(),
            'fic_equipment_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'remarks' => $this->text(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-fic_equipment_status_history-fic_equipment_id', '{{%fic_equipment_status_history}}', 'fic_equipment_id');
        $this->addForeignKey('fk-fic_equipment_status_history-fic_equipment_id', '{{%fic_equipment_status_history}}', 'fic_equipment_id', '{{%fic_equipment}}', 'id', 'CASCADE');

        $this->createIndex('idx-fic_equipment_status_history-created_by', '{{%fic_equipment_status_history}}', 'created_by');
        $this->addForeignKey('fk-fic_equipment_status_history-created_by', '{{%fic_equipment_status_history}}', 'created_by', '{{%user}}', 'id', 'SET NULL');

        $this->createIndex('idx-fic_equipment_status_history-updated_by', '{{%fic_equipment_status_history}}', 'updated_by');
        $this->addForeignKey('fk-fic_equipment_status_history-updated_by', '{{%fic_equipment_status_history}}', 'updated_by', '{{%user}}', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic_equipment_status_history-fic_equipment_id', '{{%fic_equipment_status_history}}');
        $this->dropIndex('idx-fic_equipment_status_history-fic_equipment_id', '{{%fic_equipment_status_history}}');

        $this->dropForeignKey('fk-fic_equipment_status_history-created_by', '{{%fic_equipment_status_history}}');
        $this->dropIndex('idx-fic_equipment_status_history-created_by', '{{%fic_equipment_status_history}}');

        $this->dropForeignKey('fk-fic_equipment_status_history-updated_by', '{{%fic_equipment_status_history}}');
        $this->dropIndex('idx-fic_equipment_status_history-updated_by', '{{%fic_equipment_status_history}}');

        $this->dropTable('{{%fic_equipment_status_history}}');
    }
}
