<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment}}`.
 */
class m220830_024557_create_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment}}', [
            'id' => $this->primaryKey(),
            'model' => $this->string(200)->notNull()->unique(),
            'equipment_type_id' => $this->integer()->notNull(),
            'equipment_category_id' => $this->integer()->notNull(),
            'processing_capability_id' => $this->integer()->notNull(),
            'image_id' => $this->integer(),
            'isDeleted' => $this->boolean()->defaultValue(false),
            'version' => $this->integer()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-equipment-equipment_type_id', '{{%equipment}}', 'equipment_type_id');
        $this->addForeignKey('fk-equipment-equipment_type_id', '{{%equipment}}', 'equipment_type_id', '{{%equipment_type}}', 'id', 'CASCADE');

        $this->createIndex('idx-equipment-equipment_category_id', '{{%equipment}}', 'equipment_category_id');
        $this->addForeignKey('fk-equipment-equipment_category_id', '{{%equipment}}', 'equipment_category_id', '{{%equipment_category}}', 'id', 'CASCADE');

        $this->createIndex('idx-equipment-processing_capability_id', '{{%equipment}}', 'processing_capability_id');
        $this->addForeignKey('fk-equipment-processing_capability_id', '{{%equipment}}', 'processing_capability_id', '{{%processing_capability}}', 'id', 'CASCADE');

        $this->createIndex('idx-equipment-image_id', '{{%equipment}}', 'image_id');
        $this->addForeignKey('fk-equipment-image_id', '{{%equipment}}', 'image_id', '{{%media}}', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment-equipment_type_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-equipment_type_id', '{{%equipment}}');

        $this->dropForeignKey('fk-equipment-equipment_category_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-equipment_category_id', '{{%equipment}}');

        $this->dropForeignKey('fk-equipment-processing_capability_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-processing_capability_id', '{{%equipment}}');

        $this->dropForeignKey('fk-equipment-image_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-image_id', '{{%equipment}}');

        $this->dropTable('{{%equipment}}');
    }
}
