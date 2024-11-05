<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fic".
 *
 * @property int $id
 * @property string $name
 * @property int|null $municipality_city_id
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $suc
 * @property string|null $address
 * @property double|0 $longitude
 * @property double|0 $latitude
 * @property string|null $contact_person
 * @property string|null $email
 * @property string|null $contact_number
 *
 * @property Facility[] $facilities
 * @property FicEquipment[] $ficEquipments
 * @property FicFacility[] $ficFacilities
 * @property FicPersonnel[] $ficPersonnels
 * @property FicService[] $ficServices
 * @property JobOrderRequest[] $jobOrderRequests
 * @property MunicipalityCity $municipalityCity
 * @property Service[] $services
 * @property UserProfile[] $userProfiles
 * @property UserProfile[] $userProfiles0
 */
class Fic extends \yii\db\ActiveRecord
{
    public $region_id;
    public $province_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'municipality_city_id', 'region_id', 'province_id'], 'required'],
            [['municipality_city_id', 'municipality_city_id', 'region_id', 'province_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address'], 'string', 'max' => 150],
            [['contact_person', 'email'], 'string', 'max' => 128],
            [['contact_number'], 'string', 'max' => 32],
            [['suc'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['email'], 'email'],
            [['longitude', 'latitude'], 'number'],
            [['municipality_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => MunicipalityCity::class, 'targetAttribute' => ['municipality_city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'municipality_city_id' => 'Municipality/City',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'suc' => 'Suc',
            'address' => 'Address',
            'contact_person' => 'Contact Person',
            'email' => 'Email',
            'contact_number' => 'Contact Number',
        ];
    }

    /**
     * Gets query for [[Facilities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFacilities()
    {
        return $this->hasMany(Facility::className(), ['id' => 'facility_id'])->via('ficFacilities');
    }

    /**
     * Gets query for [[FicEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicEquipments()
    {
        return $this->hasMany(FicEquipment::className(), ['fic_id' => 'id']);
    }

    /**
     * Gets query for [[FicFacilities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicFacilities()
    {
        return $this->hasMany(FicFacility::class, ['fic_id' => 'id']);
    }

    /**
     * Gets query for [[FicPersonnels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicPersonnels()
    {
        return $this->hasMany(FicPersonnel::className(), ['fic_id' => 'id']);
    }

    /**
     * Gets query for [[FicServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicServices()
    {
        return $this->hasMany(FicService::class, ['fic_id' => 'id']);
    }

    /**
     * Gets query for [[JobOrderRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    // public function getJobOrderRequests()
    // {
    //     return $this->hasMany(JobOrderRequest::className(), ['fic_id' => 'id']);
    // }

    /**
     * Gets query for [[MunicipalityCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalityCity()
    {
        return $this->hasOne(MunicipalityCity::class, ['id' => 'municipality_city_id']);
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'province_id'])->via('municipalityCity');
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id'])->via('province');
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])->via('ficServices');
    }

    /**
     * Gets query for [[UserProfiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasMany(UserProfile::className(), ['fic_affiliation' => 'id']);
    }

    /**
     * Gets query for [[UserProfiles0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles0()
    {
        return $this->hasMany(UserProfile::class, ['id' => 'user_profile_id'])->via('ficPersonnels');
    }

    public static function getFics()
    {
        return self::find()->orderBy(['name' => SORT_ASC])->all();
    }
}
