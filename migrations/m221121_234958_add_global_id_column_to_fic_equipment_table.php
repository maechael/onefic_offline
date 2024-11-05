<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic_equipment}}`.
 */
class m221121_234958_add_global_id_column_to_fic_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic_equipment}}', 'global_id', $this->string()->notNull()->after('id'));
        $this->createIndex('idx-fic_equipment-global_id', '{{%fic_equipment}}', 'global_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-fic_equipment-global_id', '{{%fic_equipment}}');
        $this->dropColumn('{{%fic_equipment}}', 'global_id');
    }
}
