<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%branch}}`.
 */
class m220826_055551_create_branch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%branch}}', [
            'id' => $this->primaryKey(),
            'supplier_id' => $this->integer()->notNull(),
            'organization_status' => $this->integer(),
            'contact_person' => $this->string(),
            'celNumber' => $this->string(),
            'email' => $this->string(),
            'telNumber' => $this->string(),
            'region_id' => $this->integer()->notNull(),
            'province_id' => $this->integer()->notNull(),
            'municipality_city_id' => $this->integer()->notNull(),
            'address' => $this->string(),
            'version' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            '{{%idx-branch-supplier_id}}',
            '{{%branch}}',
            'supplier_id'
        );

        $this->addForeignKey(
            '{{%fk-branch-supplier_id}}',
            '{{%branch}}',
            'supplier_id',
            '{{%supplier}}',
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
            '{{%fk-branch-supplier_id}}',
            '{{%branch}}'
        );

        $this->dropIndex(
            '{{%idx-branch-supplier_id}}',
            '{{%branch}}'
        );

        $this->dropTable('{{%branch}}');
    }
}
