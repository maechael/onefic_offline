<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_spec}}`.
 */
class m220919_073208_create_equipment_spec_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_spec}}', [
            'id' => $this->primaryKey(),
            'equipment_id' => $this->integer()->notNull(),
            'spec_key_id' => $this->integer(),
            'value' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('{{%idx-equipment_spec-equipment_id}}', '{{%equipment_spec}}', 'equipment_id');

        $this->addForeignKey(
            '{{%fk-equipment_spec-equipment_id}}',
            '{{%equipment_spec}}',
            'equipment_id',
            '{{%equipment}}',
            'id',
            'CASCADE'
        );

        $this->createIndex('{{%idx-equipment_spec-spec_key_id}}', '{{%equipment_spec}}', 'spec_key_id');

        $this->addForeignKey(
            '{{%fk-equipment_spec-spec_key_id}}',
            '{{%equipment_spec}}',
            'spec_key_id',
            '{{%spec_key}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-equipment_spec-equipment_id}}', '{{%equipment_spec}}');
        $this->dropIndex('{{%idx-equipment_spec-equipment_id}}', '{{%equipment_spec}}');

        $this->dropForeignKey('{{%fk-equipment_spec-spec_key_id}}', '{{%equipment_spec}}');
        $this->dropIndex('{{%idx-equipment_spec-spec_key_id}}', '{{%equipment_spec}}');

        $this->dropTable('{{%equipment_spec}}');
    }
}
