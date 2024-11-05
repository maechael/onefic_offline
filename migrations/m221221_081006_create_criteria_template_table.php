<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%criteria_template}}`.
 */
class m221221_081006_create_criteria_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%criteria_template}}', [
            'id' => $this->primaryKey(),
            'checklist_component_template_id' => $this->integer(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-criteria_template-checklist_component_template_id', '{{%criteria_template}}', 'checklist_component_template_id');
        $this->addForeignKey('fk-criteria_template-checklist_component_template_id', '{{%criteria_template}}', 'checklist_component_template_id', '{{%checklist_component_template}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-criteria_template-checklist_component_template_id', '{{%criteria_template}}');
        $this->dropIndex('idx-criteria_template-checklist_component_template_id', '{{%criteria_template}}');

        $this->dropTable('{{%criteria_template}}');
    }
}
