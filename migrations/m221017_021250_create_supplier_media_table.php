<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier_media}}`.
 */
class m221017_021250_create_supplier_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier_media}}', [
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'media_id' => $this->integer(),
            'media_type' => $this->string()
        ]);

        $this->createIndex('idx-supplier_media-supplier_id', '{{%supplier_media}}', 'supplier_id');
        $this->addForeignKey('fk-supplier_media-supplier_id', '{{%supplier_media}}', 'supplier_id', '{{%supplier}}', 'id', 'CASCADE');

        $this->createIndex('idx-supplier_media-branch_id', '{{%supplier_media}}', 'branch_id');
        $this->addForeignKey('fk-supplier_media-branch_id', '{{%supplier_media}}', 'branch_id', '{{%branch}}', 'id', 'CASCADE');

        $this->createIndex('idx-supplier_media-media_id', '{{%supplier_media}}', 'media_id');
        $this->addForeignKey('fk-supplier_media-media_id', '{{%supplier_media}}', 'media_id', '{{%media}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-supplier_media-supplier_id', '{{%supplier_media}}');
        $this->dropIndex('idx-supplier_media-supplier_id', '{{%supplier_media}}');

        $this->dropForeignKey('fk-supplier_media-branch_id', '{{%supplier_media}}');
        $this->dropIndex('idx-supplier_media-branch_id', '{{%supplier_media}}');

        $this->dropForeignKey('fk-supplier_media-media_id', '{{%supplier_media}}');
        $this->dropIndex('idx-supplier_media-media_id', '{{%supplier_media}}');

        $this->dropTable('{{%supplier_media}}');
    }
}
