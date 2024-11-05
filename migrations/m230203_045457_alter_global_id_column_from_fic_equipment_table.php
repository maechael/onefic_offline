<?php

use yii\db\Migration;

/**
 * Class m230203_045457_alter_global_id_column_from_fic_equipment_table
 */
class m230203_045457_alter_global_id_column_from_fic_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%fic_equipment}}', 'global_id', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%fic_equipment}}', 'global_id', $this->string()->notNull());
    }
}
