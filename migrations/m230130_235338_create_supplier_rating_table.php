<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_rating}}`.
 */
class m230130_235338_create_supplier_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $tableSchema = $this->db->getTableSchema('{{%supplier_rating}}');

            if ($tableSchema) {
                $this->dropTable('{{%supplier_rating}}');
            }

            $this->createTable('{{%supplier_rating}}', [
                'id' => $this->primaryKey(),
                'supplier_id' => $this->integer()->notNull(),
                'equipment_issue_repair_id' => $this->integer(),
                'fic_id' => $this->integer(),
                'rating' => $this->double()->defaultValue(0)->notNull(),
                'review' => $this->text(),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
            ]);

            $this->createIndex('idx-supplier_rating-supplier_id', '{{%supplier_rating}}', 'supplier_id');
            $this->addForeignKey('fk-supplier_rating-supplier_id', '{{%supplier_rating}}', 'supplier_id', '{{%supplier}}', 'id', 'CASCADE');

            $this->createIndex('idx-supplier_rating-equipment_issue_repair_id', '{{%supplier_rating}}', 'equipment_issue_repair_id');
            $this->addForeignKey('fk-supplier_rating-equipment_issue_repair_id', '{{%supplier_rating}}', 'equipment_issue_repair_id', '{{%equipment_issue_repair}}', 'id', 'SET NULL');

            $this->createIndex('idx-supplier_rating-fic_id', '{{%supplier_rating}}', 'fic_id');
            $this->addForeignKey('fk-supplier_rating-fic_id', '{{%supplier_rating}}', 'fic_id', '{{%fic}}', 'id', 'SET NULL');

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
            $tableSchema = $this->db->getTableSchema('{{%supplier_rating}}');
            if ($tableSchema) {
                $this->dropForeignKey('fk-supplier_rating-supplier_id', '{{%supplier_rating}}');
                $this->dropIndex('idx-supplier_rating-supplier_id', '{{%supplier_rating}}');

                $this->dropForeignKey('fk-supplier_rating-equipment_issue_repair_id', '{{%supplier_rating}}');
                $this->dropIndex('idx-supplier_rating-equipment_issue_repair_id', '{{%supplier_rating}}');

                $this->dropForeignKey('fk-supplier_rating-fic_id', '{{%supplier_rating}}');
                $this->dropIndex('idx-supplier_rating-fic_id', '{{%supplier_rating}}');

                $this->dropTable('{{%supplier_rating}}');
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
