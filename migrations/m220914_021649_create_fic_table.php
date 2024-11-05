<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic}}`.
 */
class m220914_021649_create_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull()->unique(),
            'municipality_city_id' => $this->integer(),
            'suc' => $this->string(),
            'address' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-fic-municipality_city_id', '{{%fic}}', 'municipality_city_id');
        $this->addForeignKey('fk-fic-municipality_city_id', '{{%fic}}', 'municipality_city_id', '{{%municipality_city}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic-municipality_city_id', '{{%fic}}');
        $this->dropIndex('idx-fic-municipality_city_id', '{{%fic}}');

        $this->dropTable('{{%fic}}');
    }
}
