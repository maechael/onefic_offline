<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%province}}`.
 */
class m220826_052600_create_province_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%province}}', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-province-region_id', '{{%province}}', 'region_id');
        $this->addForeignKey('fk-province-region_id', '{{%province}}', 'region_id', '{{%region}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-province-region_id', '{{%province}}');
        $this->dropIndex('idx-province-region_id', '{{%province}}');
        $this->dropTable('{{%province}}');
    }
}
