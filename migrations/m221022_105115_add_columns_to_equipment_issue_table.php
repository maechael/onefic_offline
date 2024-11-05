<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%equipment_issue}}`.
 */
class m221022_105115_add_columns_to_equipment_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_issue}}', 'reported_by', $this->string(64)->after('status'));
        $this->addColumn('{{%equipment_issue}}', 'created_by', $this->integer()->after('reported_by'));

        $this->createIndex('idx-equipment_issue-created_by', '{{%equipment_issue}}', 'created_by');
        $this->addForeignKey('fk-equipment_issue-created_by', '{{%equipment_issue}}', 'created_by', '{{%user}}', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment_issue-created_by', '{{%equipment_issue}}');
        $this->dropIndex('idx-equipment_issue-created_by', '{{%equipment_issue}}');

        $this->dropColumn('{{%equipment_issue}}', 'reported_by');
        $this->dropColumn('{{%equipment_issue}}', 'created_by');
    }
}
