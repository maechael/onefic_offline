<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_component}}`.
 */
class m220830_030504_create_equipment_component_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_component}}', [
            'id' => $this->primaryKey(),
            'equipment_id' => $this->integer()->notNull(),
            'component_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            '{{%idx-equipment_component-equipment_id}}',
            '{{%equipment_component}}',
            'equipment_id'
        );

        $this->addForeignKey(
            '{{%fk-equipment_component-equipment_id}}',
            '{{%equipment_component}}',
            'equipment_id',
            '{{%equipment}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-equipment_component-component_id}}',
            '{{%equipment_component}}',
            'component_id'
        );

        $this->addForeignKey(
            '{{%fk-equipment_component-component_id}}',
            '{{%equipment_component}}',
            'component_id',
            '{{%component}}',
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
            '{{%fk-equipment_component-equipment_id}}',
            '{{%equipment_component}}'
        );

        $this->dropIndex(
            '{{%idx-equipment_component-equipment_id}}',
            '{{%equipment_component}}'
        );

        $this->dropForeignKey(
            '{{%fk-equipment_component-component_id}}',
            '{{%equipment_component}}'
        );

        $this->dropIndex(
            '{{%idx-equipment_component-component_id}}',
            '{{%equipment_component}}'
        );

        $this->dropTable('{{%equipment_component}}');
    }
}
