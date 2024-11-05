<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%local_media}}`.
 */
class m221022_111118_create_local_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%local_media}}', [
            'id' => $this->primaryKey(),
            'basename' => $this->string(255)->notNull(),
            'filename' => $this->string()->notNull(),
            'filepath' => $this->string()->notNull(),
            'type' => $this->string(50)->notNull(),
            'size' => $this->integer()->notNull(),
            'extension' => $this->string(50)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%local_media}}');
    }
}
