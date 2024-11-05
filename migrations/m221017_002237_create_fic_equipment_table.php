<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_equipment}}`.
 */
class m221017_002237_create_fic_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_equipment}}', [
            'id' => $this->primaryKey(),
            'fic_id' => $this->integer(),
            'equipment_id' => $this->integer()->notNull(),
            'serial_number' => $this->string(100)->notNull()->unique(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'isDeleted' => $this->boolean()->defaultValue(false),
            'version' => $this->integer()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-fic_equipment-fic_id', '{{%fic_equipment}}', 'fic_id');
        $this->addForeignKey('fk-fic_equipment-fic_id', '{{%fic_equipment}}', 'fic_id', '{{%fic}}', 'id', 'SET NULL');

        $this->createIndex('idx-fic_equipment-equipment_id', '{{%fic_equipment}}', 'equipment_id');
        $this->addForeignKey('fk-fic_equipment-equipment_id', '{{%fic_equipment}}', 'equipment_id', '{{%equipment}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic_equipment-fic_id', '{{%fic_equipment}}');
        $this->dropIndex('idx-fic_equipment-fic_id', '{{%fic_equipment}}');

        $this->dropForeignKey('fk-fic_equipment-equipment_id', '{{%fic_equipment}}');
        $this->dropIndex('idx-fic_equipment-equipment_id', '{{%fic_equipment}}');

        $this->dropTable('{{%fic_equipment}}');
    }
}
