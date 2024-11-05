<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic_equipment}}`.
 */
class m221026_082317_add_remarks_column_to_fic_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic_equipment}}', 'remarks', $this->text()->after('status'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fic_equipment}}', 'remarks');
    }
}
