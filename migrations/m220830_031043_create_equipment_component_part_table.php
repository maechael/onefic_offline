<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_component_part}}`.
 */
class m220830_031043_create_equipment_component_part_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_component_part}}', [
            'id' => $this->primaryKey(),
            'equipment_component_id' => $this->integer()->notNull(),
            'part_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            '{{%idx-equipment_component_part-equipment_component_id}}',
            '{{%equipment_component_part}}',
            'equipment_component_id'
        );

        $this->addForeignKey(
            '{{%fk-equipment_component_part-equipment_component_id}}',
            '{{%equipment_component_part}}',
            'equipment_component_id',
            '{{%equipment_component}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-equipment_component_part-part_id}}',
            '{{%equipment_component_part}}',
            'part_id'
        );

        $this->addForeignKey(
            '{{%fk-equipment_component_part-part_id}}',
            '{{%equipment_component_part}}',
            'part_id',
            '{{%part}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-equipment_component_part-equipment_component_id}}',
            '{{%equipment_component_part}}'
        );

        $this->dropIndex(
            '{{%idx-equipment_component_part-equipment_component_id}}',
            '{{%equipment_component_part}}'
        );

        $this->dropForeignKey(
            '{{%fk-equipment_component_part-part_id}}',
            '{{%equipment_component_part}}'
        );

        $this->dropIndex(
            '{{%idx-equipment_component_part-part_id}}',
            '{{%equipment_component_part}}'
        );

        $this->dropTable('{{%equipment_component_part}}');
    }
}
