<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%part_supplier}}`.
 */
class m220830_033149_create_part_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%part_supplier}}', [
            'id' => $this->primaryKey(),
            'part_id' => $this->integer()->notNull(),
            'supplier_id' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            '{{%idx-part_supplier-part_id}}',
            '{{%part_supplier}}',
            'part_id'
        );

        $this->addForeignKey(
            '{{%fk-part_supplier-part_id}}',
            '{{%part_supplier}}',
            'part_id',
            '{{%part}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-part_supplier-supplier_id}}',
            '{{%part_supplier}}',
            'supplier_id'
        );

        $this->addForeignKey(
            '{{%fk-part_supplier-supplier_id}}',
            '{{%part_supplier}}',
            'supplier_id',
            '{{%supplier}}',
            'id',
            'CASCADE'
        );

        $this->createIndex('{{%idx-unique-part_supplier-part_id-supplier-id}}', '{{%part_supplier}}', ['part_id', 'supplier_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-part_supplier-part_id}}',
            '{{%part_supplier}}'
        );

        $this->dropIndex(
            '{{%idx-part_supplier-part_id}}',
            '{{%part_supplier}}'
        );

        $this->dropForeignKey(
            '{{%fk-part_supplier-supplier_id}}',
            '{{%part_supplier}}'
        );

        $this->dropIndex(
            '{{%idx-part_supplier-supplier_id}}',
            '{{%part_supplier}}'
        );

        $this->dropIndex(
            '{{%idx-unique-part_supplier-part_id-supplier-id}}',
            '{{%part_supplier}}'
        );

        $this->dropTable('{{%part_supplier}}');
    }
}
