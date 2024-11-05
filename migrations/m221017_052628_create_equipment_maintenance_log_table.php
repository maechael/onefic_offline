<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_maintenance_log}}`.
 */
class m221017_052628_create_equipment_maintenance_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_maintenance_log}}', [
            'id' => $this->primaryKey(),
            'fic_equipment_id' => $this->integer()->notNull(),
            'maintenance_date' => $this->date()->notNull(),
            'time_started' => $this->time(),
            'time_ended' => $this->time(),
            'conclusion_recommendation' => $this->text(),
            'inspected_checked_by' => $this->string(),
            'noted_by' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-equipment_maintenance_log-fic_equipment_id', '{{%equipment_maintenance_log}}', 'fic_equipment_id');
        $this->addForeignKey('fk-equipment_maintenance_log-fic_equipment_id', '{{%equipment_maintenance_log}}', 'fic_equipment_id', '{{%fic_equipment}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment_maintenance_log-fic_equipment_id', '{{%equipment_maintenance_log}}');
        $this->dropIndex('idx-equipment_maintenance_log-fic_equipment_id', '{{%equipment_maintenance_log}}');

        $this->dropTable('{{%equipment_maintenance_log}}');
    }
}
