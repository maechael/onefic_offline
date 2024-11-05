<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%maintenance_checklist_log}}`.
 */
class m221222_023419_create_maintenance_checklist_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            if ($this->db->getTableSchema('{{%maintenance_checklist_log}}')) {
                $this->dropTable('{{%maintenance_checklist_log}}');
            }

            $this->createTable('{{%maintenance_checklist_log}}', [
                'id' => $this->primaryKey(),
                'global_id' => $this->string()->notNull(),
                'fic_equipment_id' => $this->integer()->notNull(),
                'accomplished_by_name' => $this->string(128)->notNull(),
                'accomplished_by_designation' => $this->string(128)->notNull(),
                'accomplished_by_office' => $this->string()->notNull(),
                'accomplished_by_date' => $this->date(),
                'endorsed_by_name' => $this->string(128)->notNull(),
                'endorsed_by_designation' => $this->string(128)->notNull(),
                'endorsed_by_office' => $this->string()->notNull(),
                'endorsed_by_date' => $this->date(),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            ]);

            $this->createIndex('idx-maintenance_checklist_log-global_id', '{{%maintenance_checklist_log}}', 'global_id');

            $this->createIndex('idx-maintenance_checklist_log-fic_equipment_id', '{{%maintenance_checklist_log}}', 'fic_equipment_id');
            $this->addForeignKey('fk-maintenance_checklist_log-fic_equipment_id', '{{%maintenance_checklist_log}}', 'fic_equipment_id', '{{%fic_equipment}}', 'id', 'CASCADE');

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
            if ($tableSchema = $this->db->getTableSchema('{{%maintenance_checklist_log}}')) {
                $foreignKeys = $tableSchema->foreignKeys;
                $idxFicEquipmentId = $this->db->createCommand("SHOW INDEXES FROM `maintenance_checklist_log` WHERE `Key_name` = 'idx-maintenance_checklist_log-fic_equipment_id'")->queryAll();
                $idxGlobalId = $this->db->createCommand("SHOW INDEXES FROM `maintenance_checklist_log` WHERE `Key_name` = 'idx-maintenance_checklist_log-global_id'")->queryAll();
                // $indexes = $this->db->schema->findUniqueIndexes($tableSchema);

                if ($idxGlobalId) {
                    $this->dropIndex('idx-maintenance_checklist_log-global_id', '{{%maintenance_checklist_log}}');
                }

                if (isset($foreignKeys['fk-maintenance_checklist_log-fic_equipment_id'])) {
                    $this->dropForeignKey('fk-maintenance_checklist_log-fic_equipment_id', '{{%maintenance_checklist_log}}');
                }

                if ($idxFicEquipmentId) {
                    $this->dropIndex('idx-maintenance_checklist_log-fic_equipment_id', '{{%maintenance_checklist_log}}');
                }

                $this->dropTable('{{%maintenance_checklist_log}}');
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
