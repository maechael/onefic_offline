<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%equipment_issue_repair}}`.
 */
class m221214_015443_add_equipment_issue_gid_column_to_equipment_issue_repair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_issue_repair}}', 'equipment_issue_gid', $this->string()->notNull()->after('equipment_issue_id'));

        $this->createIndex('idx-equipment_issue_repair-equipment_issue_gid', '{{%equipment_issue_repair}}', 'equipment_issue_gid');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-equipment_issue_repair-equipment_issue_gid', '{{%equipment_issue_repair}}');

        $this->dropColumn('{{%equipment_issue_repair}}', 'equipment_issue_gid');
    }
}
