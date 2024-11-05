<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%municipality_city}}`.
 */
class m220826_053209_create_municipality_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%municipality_city}}', [
            'id' => $this->primaryKey(),
            'region_id' => $this->integer()->notNull(),
            'province_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'district' => $this->string(100),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-municipality_city-region_id', '{{%municipality_city}}', 'region_id');
        $this->addForeignKey('fk-municipality_city-region_id', '{{%municipality_city}}', 'region_id', '{{%region}}', 'id', 'CASCADE');

        $this->createIndex('idx-municipality_city-province_id', '{{%municipality_city}}', 'province_id');
        $this->addForeignKey('fk-municipality_city-province_id', '{{%municipality_city}}', 'province_id', '{{%province}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-municipality_city-region_id', '{{%municipality_city}}');
        $this->dropIndex('idx-municipality_city-region_id', '{{%municipality_city}}');

        $this->dropForeignKey('fk-municipality_city-province_id', '{{%municipality_city}}');
        $this->dropIndex('idx-municipality_city-province_id', '{{%municipality_city}}');

        $this->dropTable('{{%municipality_city}}');
    }
}
