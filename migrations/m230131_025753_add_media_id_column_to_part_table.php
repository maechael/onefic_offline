<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%part}}`.
 */
class m230131_025753_add_media_id_column_to_part_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $tableSchema = $this->db->getTableSchema('{{%part}}');
            if ($tableSchema) {
                if (!$tableSchema->getColumn('media_id')) {
                    $this->addColumn('{{%part}}', 'media_id', $this->integer()->after('name'));

                    $this->createIndex('{{%idx-part-media_id}}', '{{%part}}', 'media_id');
                    $this->addForeignKey('{{%fk-part-media_id}}', '{{%part}}', 'media_id', '{{%media}}', 'id', 'SET NULL');
                }
            }
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
            $this->dropForeignKey('{{%fk-part-media_id}}', '{{%part}}');

            $this->dropIndex('{{%idx-part-media_id}}', '{{%part}}');

            $this->dropColumn('{{%part}}', 'media_id');

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
