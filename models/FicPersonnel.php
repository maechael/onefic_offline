<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fic_personnel".
 *
 * @property int $fic_id
 * @property int $user_profile_id
 *
 * @property Fic $fic
 * @property UserProfile $userProfile
 */
class FicPersonnel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic_personnel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_id', 'user_profile_id'], 'required'],
            [['fic_id', 'user_profile_id'], 'integer'],
            [['user_profile_id'], 'unique'],
            [['fic_id', 'user_profile_id'], 'unique', 'targetAttribute' => ['fic_id', 'user_profile_id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_id' => 'id']],
            [['user_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['user_profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fic_id' => 'Fic ID',
            'user_profile_id' => 'User Profile ID',
        ];
    }

    /**
     * Gets query for [[Fic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_id']);
    }

    /**
     * Gets query for [[UserProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'user_profile_id']);
    }
}
