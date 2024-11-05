<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_issue}}`.
 */
class m221017_014626_create_equipment_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_issue}}', [
            'id' => $this->primaryKey(),
            'fic_equipment_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->notNull(),
            'description' => $this->text()->notNull(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-equipment_issue-fic_equipment_id', '{{%equipment_issue}}', 'fic_equipment_id');
        $this->addForeignKey('fk-equipment_issue-fic_equipment_id', '{{%equipment_issue}}', 'fic_equipment_id', '{{%fic_equipment}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment_issue-fic_equipment_id', '{{%equipment_issue}}');
        $this->dropIndex('idx-equipment_issue-fic_equipment_id', '{{%equipment_issue}}');

        $this->dropTable('{{%equipment_issue}}');
    }
}
