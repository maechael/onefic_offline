<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%equipment_issue_repair}}`.
 */
class m221024_020201_add_remarks_column_to_equipment_issue_repair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_issue_repair}}', 'remarks', $this->text()->after('repair_activity'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%equipment_issue_repair}}', 'remarks');
    }
}
