<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checklist_criteria}}`.
 */
class m221222_050620_create_checklist_criteria_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            if ($this->db->getTableSchema('{{%checklist_criteria}}')) {
                $this->dropTable('{{%checklist_criteria}}');
            }

            $this->createTable('{{%checklist_criteria}}', [
                'id' => $this->primaryKey(),
                'maintenance_checklist_log_id' => $this->integer()->notNull(),
                'equipment_component_id' => $this->integer(),
                'component_name' => $this->string()->notNull(),
                'criteria' => $this->text()->notNull(),
                'result' => $this->boolean()->defaultValue(true),
                'remarks' => $this->text(),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            ]);

            $this->createIndex('idx-checklist_criteria-maintenance_checklist_log_id', '{{%checklist_criteria}}', 'maintenance_checklist_log_id');
            $this->addForeignKey('fk-checklist_criteria-maintenance_checklist_log_id', '{{%checklist_criteria}}', 'maintenance_checklist_log_id', '{{%maintenance_checklist_log}}', 'id', 'CASCADE');

            $this->createIndex('idx-checklist_criteria-equipment_component_id', '{{%checklist_criteria}}', 'equipment_component_id');
            $this->addForeignKey('fk-checklist_criteria-equipment_component_id', '{{%checklist_criteria}}', 'equipment_component_id', '{{%equipment_component}}', 'id', 'SET NULL');

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $transaction = $this->db->beginTransaction();
        try {
            if ($tableSchema = $this->db->getTableSchema('{{%checklist_criteria}}')) {
                $foreignKeys = $tableSchema->foreignKeys;
                $indexes = $this->db->createCommand("SHOW INDEXES FROM `checklist_criteria` WHERE `Key_name` = 'idx-checklist_criteria-maintenance_checklist_log_id'")->queryAll();

                if (isset($foreignKeys['fk-checklist_criteria-maintenance_checklist_log_id']))
                    $this->dropForeignKey('fk-checklist_criteria-maintenance_checklist_log_id', '{{%checklist_criteria}}');
                if ($indexes)
                    $this->dropIndex('idx-checklist_criteria-maintenance_checklist_log_id', '{{%checklist_criteria}}');

                if (isset($foreignKeys['fk-checklist_criteria-equipment_component_id']))
                    $this->dropForeignKey('fk-checklist_criteria-equipment_component_id', '{{%checklist_criteria}}');

                $indexes = $this->db->createCommand("SHOW INDEXES FROM `checklist_criteria` WHERE `Key_name` = 'idx-checklist_criteria-equipment_component_id'")->queryAll();
                if ($indexes)
                    $this->dropIndex('idx-checklist_criteria-equipment_component_id', '{{%checklist_criteria}}');

                $this->dropTable('{{%checklist_criteria}}');
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
