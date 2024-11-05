<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic}}`.
 */
class m221019_014357_add_columns_to_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic}}', 'longitude', $this->decimal(20, 14)->defaultValue(0)->after('address'));
        $this->addColumn('{{%fic}}', 'latitude', $this->decimal(20, 14)->defaultValue(0)->after('longitude'));
        $this->addColumn('{{%fic}}', 'contact_person', $this->string(128)->after('latitude'));
        $this->addColumn('{{%fic}}', 'email', $this->string(128)->after('contact_person'));
        $this->addColumn('{{%fic}}', 'contact_number', $this->string(32)->after('email'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fic}}', 'longitude');
        $this->dropColumn('{{%fic}}', 'latitude');
        $this->dropColumn('{{%fic}}', 'contact_person');
        $this->dropColumn('{{%fic}}', 'email');
        $this->dropColumn('{{%fic}}', 'contact_number');
    }
}
