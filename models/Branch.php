<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property int $id
 * @property int $supplier_id
 * @property int|null $organization_status
 * @property string|null $contact_person
 * @property string|null $celNumber
 * @property string|null $email
 * @property string|null $telNumber
 * @property int $region_id
 * @property int $province_id
 * @property int $municipality_city_id
 * @property string|null $address
 * @property int $version
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Supplier $supplier
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id', 'region_id', 'province_id', 'municipality_city_id'], 'required'],
            [['supplier_id', 'organization_status', 'region_id', 'province_id', 'municipality_city_id', 'version'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['contact_person', 'celNumber', 'email', 'telNumber', 'address'], 'string', 'max' => 255],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supplier_id' => 'Supplier ID',
            'organization_status' => 'Organization Status',
            'contact_person' => 'Contact Person',
            'celNumber' => 'Cel Number',
            'email' => 'Email',
            'telNumber' => 'Tel Number',
            'region_id' => 'Region ID',
            'province_id' => 'Province ID',
            'municipality_city_id' => 'Municipality City ID',
            'address' => 'Address',
            'version' => 'Version',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'province_id']);
    }

    /**
     * Gets query for [[MunicipalityCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalityCity()
    {
        return $this->hasOne(MunicipalityCity::class, ['id' => 'municipality_city_id']);
    }
}
