<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checklist_component_template}}`.
 */
class m221221_080731_create_checklist_component_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%checklist_component_template}}', [
            'id' => $this->primaryKey(),
            'equipment_id' => $this->integer(),
            'equipment_component_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-checklist_component_template-equipment_id', '{{%checklist_component_template}}', 'equipment_id');
        $this->addForeignKey('fk-checklist_component_template-equipment_id', '{{%checklist_component_template}}', 'equipment_id', '{{%equipment}}', 'id', 'CASCADE');

        $this->createIndex('idx-checklist_component_template-equipment_component_id', '{{%checklist_component_template}}', 'equipment_component_id');
        $this->addForeignKey('fk-checklist_component_template-equipment_component_id', '{{%checklist_component_template}}', 'equipment_component_id', 'equipment_component', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-checklist_component_template-equipment_id', '{{%checklist_component_template}}');
        $this->dropIndex('idx-checklist_component_template-equipment_id', '{{%checklist_component_template}}');

        $this->dropForeignKey('fk-checklist_component_template-equipment_component_id', '{{%checklist_component_template}}');
        $this->dropIndex('idx-checklist_component_template-equipment_component_id', '{{%checklist_component_template}}');
        
        $this->dropTable('{{%checklist_component_template}}');
    }
}
