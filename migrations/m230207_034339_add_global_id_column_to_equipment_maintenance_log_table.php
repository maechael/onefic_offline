<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%equipment_maintenance_log}}`.
 */
class m230207_034339_add_global_id_column_to_equipment_maintenance_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_maintenance_log}}', 'global_id', $this->string()->after('id'));
        $this->createIndex('idx-equipment_maintenance_log-global_id', '{{%equipment_maintenance_log}}', 'global_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-equipment_maintenance_log-global_id', '{{%equipment_maintenance_log}}');
        $this->dropColumn('{{%equipment_maintenance_log}}', 'global_id');
    }
}
