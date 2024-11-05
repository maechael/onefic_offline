<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%region}}`.
 */
class m220826_052113_create_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'number' => $this->integer()->notNull(),
            'code' => $this->string(100)->unique()->notNull(),
            'name' => $this->string(100),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%region}}');
    }
}
