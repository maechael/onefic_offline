<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_service}}`.
 */
class m221017_075157_create_fic_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_service}}', [
            'fic_id' => $this->integer(),
            'service_id' => $this->integer(),
            'PRIMARY KEY(fic_id, service_id)'
        ]);

        $this->createIndex('idx-fic_service-fic_id', '{{%fic_service}}', 'fic_id');
        $this->addForeignKey('fk-fic_service-fic_id', '{{%fic_service}}', 'fic_id', '{{%fic}}', 'id', 'CASCADE');

        $this->createIndex('idx-fic_service-service_id', '{{%fic_service}}', 'service_id');
        $this->addForeignKey('fk-fic_service-service_id', '{{%fic_service}}', 'service_id', '{{%service}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic_service-fic_id', '{{%fic_service}}');
        $this->dropIndex('idx-fic_service-fic_id', '{{%fic_service}}');

        $this->dropForeignKey('fk-fic_service-service_id', '{{%fic_service}}');
        $this->dropIndex('idx-fic_service-service_id', '{{%fic_service}}');

        $this->dropTable('{{%fic_service}}');
    }
}
