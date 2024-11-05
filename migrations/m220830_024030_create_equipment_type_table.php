<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_type}}`.
 */
class m220830_024030_create_equipment_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment_type}}');
    }
}
