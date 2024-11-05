<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic_tech_service}}`.
 */
class m221220_090229_add_global_id_column_to_fic_tech_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic_tech_service}}', 'global_id', $this->string()->notNull()->after('id'));
        $this->createIndex('idx-fic_tech_service-global_id', '{{%fic_tech_service}}', 'global_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-fic_tech_service-global_id', '{{%fic_tech_service}}');
        $this->dropColumn('{{%fic_tech_service}}', 'global_id');
    }
}
