<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%maintenance_log_component_part}}`.
 */
class m221017_053605_create_maintenance_log_component_part_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%maintenance_log_component_part}}', [
            'id' => $this->primaryKey(),
            'equipment_maintenance_log_id' => $this->integer()->notNull(),
            'equipment_component_id' => $this->integer()->notNull(),
            'equipment_component_part_id' => $this->integer(),
            'isInspected' => $this->boolean()->defaultValue(true),
            'isOperational' => $this->boolean()->defaultValue(true),
            'remarks' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-maintenance_log_component_part-equipment_maintenance_log_id', '{{%maintenance_log_component_part}}', 'equipment_maintenance_log_id');
        $this->addForeignKey('fk-maintenance_log_component_part-equipment_maintenance_log_id', '{{%maintenance_log_component_part}}', 'equipment_maintenance_log_id', '{{%equipment_maintenance_log}}', 'id', 'CASCADE');

        $this->createIndex('idx-maintenance_log_component_part-equipment_component_id', '{{%maintenance_log_component_part}}', 'equipment_component_id');
        $this->addForeignKey('fk-maintenance_log_component_part-equipment_component_id', '{{%maintenance_log_component_part}}', 'equipment_component_id', '{{%equipment_component}}', 'id', 'CASCADE');

        $this->createIndex('idx-maintenance_log_component_part-equipment_component_part_id', '{{%maintenance_log_component_part}}', 'equipment_component_part_id');
        $this->addForeignKey('fk-maintenance_log_component_part-equipment_component_part_id', '{{%maintenance_log_component_part}}', 'equipment_component_part_id', '{{%equipment_component_part}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-maintenance_log_component_part-equipment_maintenance_log_id', '{{%maintenance_log_component_part}}');
        $this->dropIndex('idx-maintenance_log_component_part-equipment_maintenance_log_id', '{{%maintenance_log_component_part}}');

        $this->dropForeignKey('fk-maintenance_log_component_part-equipment_component_id', '{{%maintenance_log_component_part}}');
        $this->dropIndex('idx-maintenance_log_component_part-equipment_component_id', '{{%maintenance_log_component_part}}');

        $this->dropForeignKey('fk-maintenance_log_component_part-equipment_component_part_id', '{{%maintenance_log_component_part}}');
        $this->dropIndex('idx-maintenance_log_component_part-equipment_component_part_id', '{{%maintenance_log_component_part}}');

        $this->dropTable('{{%maintenance_log_component_part}}');
    }
}
