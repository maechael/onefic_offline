<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%issue_related_part}}`.
 */
class m221019_092706_create_issue_related_part_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%issue_related_part}}', [
            'id' => $this->primaryKey(),
            'equipment_issue_id' => $this->integer()->notNull(),
            'component_part_id' => $this->integer()->notNull(),
            'type' => $this->integer()->notNull()
        ]);

        $this->createIndex('idx-issue_related_part-equipment_issue_id', '{{%issue_related_part}}', 'equipment_issue_id');
        $this->addForeignKey('fk-issue_related_part-equipment_issue_id', '{{%issue_related_part}}', 'equipment_issue_id', '{{%equipment_issue}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-issue_related_part-equipment_issue_id', '{{%issue_related_part}}');
        $this->dropIndex('idx-issue_related_part-equipment_issue_id', '{{%issue_related_part}}');

        $this->dropTable('{{%issue_related_part}}');
    }
}
