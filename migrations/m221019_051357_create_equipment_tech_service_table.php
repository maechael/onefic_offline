<?php

use yii\db\Migration;

/**
 * Class m221019_051357_equipment_tech_service_table
 */
class m221019_051357_create_equipment_tech_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_tech_service}}', [
            'equipment_id' => $this->integer()->notNull(),
            'tech_service_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'PRIMARY KEY(equipment_id, tech_service_id)',
        ]);

        $this->createIndex(
            '{{%idx-equipment_tech_service-equipment_id}}',
            '{{%equipment_tech_service}}',
            'equipment_id'
        );

        $this->addForeignKey(
            '{{%fk-equipment_tech_service-equipment_id}}',
            '{{%equipment_tech_service}}',
            'equipment_id',
            '{{%equipment}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-equipment_tech_service-tech_service_id}}',
            '{{%equipment_tech_service}}',
            'tech_service_id'
        );

        $this->addForeignKey(
            '{{%fk-equipment_tech_service-tech_service_id}}',
            '{{%equipment_tech_service}}',
            'tech_service_id',
            '{{%tech_service}}',
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
            '{{%fk-equipment_tech_service-equipment_id}}',
            '{{%equipment_tech_service}}'
        );

        $this->dropIndex(
            '{{%idx-equipment_tech_service-equipment_id}}',
            '{{%equipment_tech_service}}'
        );

        $this->dropForeignKey(
            '{{%fk-equipment_tech_service-tech_service_id}}',
            '{{%equipment_tech_service}}'
        );

        $this->dropIndex(
            '{{%idx-equipment_tech_service-tech_service_id}}',
            '{{%equipment_tech_service}}'
        );

        $this->dropTable('{{%equipment_tech_service}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221019_051357_equipment_tech_service_table cannot be reverted.\n";

        return false;
    }
    */
}
