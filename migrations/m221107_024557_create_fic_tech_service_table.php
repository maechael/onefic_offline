<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_tech_service}}`.
 */
class m221107_024557_create_fic_tech_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_tech_service}}', [
            'id' => $this->primaryKey(),
            'fic_id' => $this->integer(),
            // 'fic_equipment_id' => $this->integer(),
            'equipment_id' => $this->integer(),
            'tech_service_id' => $this->integer(),
            'charging_type' => $this->string(),
            'charging_fee' => $this->double()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-fic_tech_service-fic_id', '{{%fic_tech_service}}', 'fic_id');
        $this->addForeignKey('fk-fic_tech_service-fic_id', '{{%fic_tech_service}}', 'fic_id', '{{%fic}}', 'id', 'CASCADE');

        // $this->createIndex('idx-fic_tech_service-fic_equipment_id', '{{%fic_tech_service}}', 'fic_equipment_id');
        // $this->addForeignKey('fk-fic_tech_service-fic_equipment_id', '{{%fic_tech_service}}', 'fic_equipment_id', '{{%fic_equipment}}', 'id', 'CASCADE');

        $this->createIndex('idx-fic_tech_service-equipment_id', '{{%fic_tech_service}}', 'equipment_id');
        $this->addForeignKey('fk-fic_tech_service-equipment_id', '{{%fic_tech_service}}', 'equipment_id', '{{%equipment}}', 'id', 'CASCADE');

        $this->createIndex('idx-fic_tech_service-tech_service_id', '{{%fic_tech_service}}', 'tech_service_id');
        $this->addForeignKey('fk-fic_tech_service-tech_service_id', '{{%fic_tech_service}}', 'tech_service_id', '{{%tech_service}}', 'id', 'CASCADE');

        $this->createIndex('idx-fic_tech_service-charging_type', '{{%fic_tech_service}}', 'charging_type');

        $this->createIndex('idx-fic_tech_service-fic_id-e_id-ts_id-c_type', '{{%fic_tech_service}}', ['fic_id', 'equipment_id', 'tech_service_id', 'charging_type'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic_tech_service-fic_id', '{{%fic_tech_service}}');
        $this->dropIndex('idx-fic_tech_service-fic_id', '{{%fic_tech_service}}');

        // $this->dropForeignKey('fk-fic_tech_service-fic_equipment_id', '{{%fic_tech_service}}');
        // $this->dropIndex('idx-fic_tech_service-fic_equipment_id', '{{%fic_tech_service}}');

        $this->dropForeignKey('fk-fic_tech_service-equipment_id', '{{%fic_tech_service}}');
        $this->dropIndex('idx-fic_tech_service-equipment_id', '{{%fic_tech_service}}');

        $this->dropForeignKey('fk-fic_tech_service-tech_service_id', '{{%fic_tech_service}}');
        $this->dropIndex('idx-fic_tech_service-tech_service_id', '{{%fic_tech_service}}');

        $this->dropIndex('idx-fic_tech_service-charging_type', '{{%fic_tech_service}}');

        $this->dropIndex('idx-fic_tech_service-fic_id-e_id-ts_id-c_type', '{{%fic_tech_service}}');

        $this->dropTable('{{%fic_tech_service}}');
    }
}
