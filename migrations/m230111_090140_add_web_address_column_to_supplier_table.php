<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%supplier}}`.
 */
class m230111_090140_add_web_address_column_to_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $tableSchema = $this->db->getTableSchema('{{%supplier}}');
            if ($tableSchema) {
                if (!$tableSchema->getColumn('web_address')) {
                    $this->addColumn('{{%supplier}}', 'web_address', $this->string()->after('email'));
                } else {
                    $this->dropColumn('{{%supplier}}', 'web_address');
                    $this->addColumn('{{%supplier}}', 'web_address', $this->string()->after('email'));
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
            $tableSchema = $this->db->getTableSchema('{{%supplier}}');
            if ($tableSchema && $tableSchema->getColumn('web_address'))
                $this->dropColumn('{{%supplier}}', 'web_address');

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
