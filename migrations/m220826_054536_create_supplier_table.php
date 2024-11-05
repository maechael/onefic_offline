<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier}}`.
 */
class m220826_054536_create_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey(),
            'organization_name' => $this->string()->notNull()->unique(),
            'form_of_organization' => $this->string(100),
            'contact_person' => $this->string(),
            'cellNumber' => $this->string(),
            'email' => $this->string(),
            'telNumber' => $this->string(),
            'region_id' => $this->integer(),
            'province_id' => $this->integer(),
            'municipality_city_id' => $this->integer(),
            'address' => $this->string(),
            'is_philgeps_registered' => $this->boolean()->defaultValue(false),
            'certificate_ref_num' => $this->string(),
            'organization_status' => $this->integer()->defaultValue(1),
            'isSupplier' => $this->boolean()->defaultValue(true),
            'isFabricator' => $this->boolean()->defaultValue(false),
            'isDeleted' => $this->boolean()->defaultValue(false),
            'version' => $this->integer()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            '{{%idx-supplier-region_id}}',
            '{{%supplier}}',
            'region_id'
        );

        $this->addForeignKey(
            '{{%fk-supplier-region_id}}',
            '{{%supplier}}',
            'region_id',
            '{{%region}}',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            '{{%idx-supplier-province_id}}',
            '{{%supplier}}',
            'province_id'
        );

        $this->addForeignKey(
            '{{%fk-supplier-province_id}}',
            '{{%supplier}}',
            'province_id',
            '{{%province}}',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            '{{%idx-supplier-municipality_city_id}}',
            '{{%supplier}}',
            'municipality_city_id'
        );

        $this->addForeignKey(
            '{{%fk-supplier-municipality_city_id}}',
            '{{%supplier}}',
            'municipality_city_id',
            '{{%municipality_city}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-supplier-region_id}}',
            '{{%supplier}}'
        );

        $this->dropIndex(
            '{{%idx-supplier-region_id}}',
            '{{%supplier}}'
        );

        $this->dropForeignKey(
            '{{%fk-supplier-province_id}}',
            '{{%supplier}}'
        );

        $this->dropIndex(
            '{{%idx-supplier-province_id}}',
            '{{%supplier}}'
        );

        $this->dropForeignKey(
            '{{%fk-supplier-municipality_city_id}}',
            '{{%supplier}}'
        );

        $this->dropIndex(
            '{{%idx-supplier-municipality_city_id}}',
            '{{%supplier}}'
        );

        $this->dropTable('{{%supplier}}');
    }
}
