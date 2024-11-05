<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_facility}}`.
 */
class m221017_071449_create_fic_facility_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_facility}}', [
            'fic_id' => $this->integer(),
            'facility_id' => $this->integer(),
            'PRIMARY KEY(fic_id, facility_id)'
        ]);

        // creates index for column `fic_id`
        $this->createIndex(
            '{{%idx-fic_facility-fic_id}}',
            '{{%fic_facility}}',
            'fic_id'
        );

        // add foreign key for table `{{%fic}}`
        $this->addForeignKey(
            '{{%fk-fic_facility-fic_id}}',
            '{{%fic_facility}}',
            'fic_id',
            '{{%fic}}',
            'id',
            'CASCADE'
        );

        // creates index for column `facility_id`
        $this->createIndex(
            '{{%idx-fic_facility-facility_id}}',
            '{{%fic_facility}}',
            'facility_id'
        );

        // add foreign key for table `{{%facility}}`
        $this->addForeignKey(
            '{{%fk-fic_facility-facility_id}}',
            '{{%fic_facility}}',
            'facility_id',
            '{{%facility}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%fic}}`
        $this->dropForeignKey(
            '{{%fk-fic_facility-fic_id}}',
            '{{%fic_facility}}'
        );

        // drops index for column `fic_id`
        $this->dropIndex(
            '{{%idx-fic_facility-fic_id}}',
            '{{%fic_facility}}'
        );

        // drops foreign key for table `{{%facility}}`
        $this->dropForeignKey(
            '{{%fk-fic_facility-facility_id}}',
            '{{%fic_facility}}'
        );

        // drops index for column `facility_id`
        $this->dropIndex(
            '{{%idx-fic_facility-facility_id}}',
            '{{%fic_facility}}'
        );

        $this->dropTable('{{%fic_facility}}');
    }
}
