<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 */
class m220914_022538_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(32)->notNull(),
            'lastname' => $this->string(32)->notNull(),
            'middlename' => $this->string(32),
            'fic_affiliation' => $this->integer(),
            'designation_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-user_profile-fic_affiliation', '{{%user_profile}}', 'fic_affiliation');
        $this->addForeignKey('fk-user_profile-fic_affiliation', '{{%user_profile}}', 'fic_affiliation', '{{%fic}}', 'id', 'SET NULL');

        $this->createIndex('{{%idx-user_profile-designation_id}}', '{{%user_profile}}', 'designation_id');
        $this->addForeignKey('{{%fk-user_profile-designation_id}}', '{{%user_profile}}', 'designation_id', '{{%designation}}', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_profile-fic_affiliation', '{{%user_profile}}');
        $this->dropIndex('idx-user_profile-fic_affiliation', '{{%user_profile}}');

        $this->dropForeignKey('{{%fk-user_profile-designation_id}}', '{{%user_profile}}');

        $this->dropIndex('{{%idx-user_profile-designation_id}}', '{{%user_profile}}');

        $this->dropTable('{{%user_profile}}');
    }
}
