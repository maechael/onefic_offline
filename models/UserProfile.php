<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string|null $middlename
 * @property int|null $fic_affiliation
 * @property int|null $designation_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ContactDetail[] $contactDetails
 * @property Designation $designation
 * @property Fic $ficAffiliation
 * @property FicPersonnel $ficPersonnel
 * @property Fic[] $fics
 * @property JobOrderRequest[] $jobOrderRequests
 * @property User[] $users
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['fic_affiliation', 'designation_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['firstname', 'lastname', 'middlename'], 'string', 'max' => 32],
            [['designation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designation::class, 'targetAttribute' => ['designation_id' => 'id']],
            [['fic_affiliation'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_affiliation' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'middlename' => 'Middlename',
            'fic_affiliation' => 'FIC Affiliation',
            'designation_id' => 'Designation',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ContactDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContactDetails()
    {
        return $this->hasMany(ContactDetail::className(), ['user_profile_id' => 'id']);
    }

    /**
     * Gets query for [[Designation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDesignation()
    {
        return $this->hasOne(Designation::className(), ['id' => 'designation_id']);
    }

    /**
     * Gets query for [[FicAffiliation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicAffiliation()
    {
        return $this->hasOne(Fic::className(), ['id' => 'fic_affiliation']);
    }

    /**
     * Gets query for [[FicPersonnel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicPersonnel()
    {
        return $this->hasOne(FicPersonnel::className(), ['user_profile_id' => 'id']);
    }

    /**
     * Gets query for [[Fics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFics()
    {
        return $this->hasMany(Fic::className(), ['id' => 'fic_id'])->via('ficPersonnel');
    }

    /**
     * Gets query for [[JobOrderRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getJobOrderRequests()
    // {
    //     return $this->hasMany(JobOrderRequest::className(), ['requestor_profile_id' => 'id']);
    // }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_profile_id' => 'id']);
    }

    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_affiliation']);
    }
    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_profile_id' => 'id']);
    }
}
