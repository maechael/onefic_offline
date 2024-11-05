<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $id
 * @property string $organization_name
 * @property string|null $form_of_organization
 * @property string|null $contact_person
 * @property string|null $cellNumber
 * @property string|null $email
 * @property string|null $web_address
 * @property string|null $telNumber
 * @property int|null $region_id
 * @property int|null $province_id
 * @property int|null $municipality_city_id
 * @property string|null $address
 * @property int|null $is_philgeps_registered
 * @property string|null $certificate_ref_num
 * @property int|null $organization_status
 * @property int|null $isSupplier
 * @property int|null $isFabricator
 * @property int|null $isDeleted
 * @property int $version
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Branch[] $branches
 * @property MunicipalityCity $municipalityCity
 * @property PartSupplier[] $partSuppliers
 * @property Part[] $parts
 * @property Province $province
 * @property Region $region
 */
class Supplier extends \yii\db\ActiveRecord
{
    const ORGANIZATION_STATUS_INACTIVE = 0;
    const ORGANIZATION_STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_name'], 'required'],
            [['region_id', 'province_id', 'municipality_city_id', 'is_philgeps_registered', 'organization_status', 'isSupplier', 'isFabricator', 'isDeleted', 'version'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['organization_name', 'contact_person', 'cellNumber', 'email', 'telNumber', 'address', 'certificate_ref_num', 'web_address'], 'string', 'max' => 255],
            [['form_of_organization'], 'string', 'max' => 100],
            [['organization_name'], 'unique'],
            [['municipality_city_id'], 'exist', 'skipOnError' => true, 'targetClass' => MunicipalityCity::className(), 'targetAttribute' => ['municipality_city_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Province::className(), 'targetAttribute' => ['province_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_name' => 'Organization Name',
            'form_of_organization' => 'Form Of Organization',
            'contact_person' => 'Contact Person',
            'cellNumber' => 'Cell Number',
            'email' => 'Email',
            'web_address' => 'Web Address',
            'telNumber' => 'Tel Number',
            'region_id' => 'Region ID',
            'province_id' => 'Province ID',
            'municipality_city_id' => 'Municipality City ID',
            'address' => 'Address',
            'is_philgeps_registered' => 'Is Philgeps Registered',
            'certificate_ref_num' => 'Certificate Ref Num',
            'organization_status' => 'Organization Status',
            'isSupplier' => 'Is Supplier',
            'isFabricator' => 'Is Fabricator',
            'isDeleted' => 'Is Deleted',
            'version' => 'Version',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Branches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['supplier_id' => 'id']);
    }

    /**
     * Gets query for [[MunicipalityCity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalityCity()
    {
        return $this->hasOne(MunicipalityCity::className(), ['id' => 'municipality_city_id']);
    }

    /**
     * Gets query for [[PartSuppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartSuppliers()
    {
        return $this->hasMany(PartSupplier::className(), ['supplier_id' => 'id']);
    }

    /**
     * Gets query for [[Parts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        return $this->hasMany(Part::className(), ['id' => 'part_id'])->via('partSuppliers');
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return $this->hasOne(Province::className(), ['id' => 'province_id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * Gets query for [[SupplierMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplierMedias()
    {
        return $this->hasMany(SupplierMedia::class, ['supplier_id' => 'id']);
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedias()
    {
        return $this->hasMany(Media::class, ['id' => 'media_id'])->via('supplierMedias');
    }

    /**
     * Gets query for [[SupplierMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMySupplierMedias()
    {
        return $this->hasMany(SupplierMedia::class, ['supplier_id' => 'id'])->onCondition(['branch_id' => null]);
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMyMedias()
    {
        return $this->hasMany(Metadata::class, ['id' => 'media_id'])->via('mySupplierMedias');
    }

    /**
     * Gets query for [[EquipmentComponentPart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponentParts()
    {
        return $this->hasMany(EquipmentComponentPart::class, ['part_id' => 'id'])->via('parts');
    }

    /**
     * Gets query for [[EquipmentComponent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['id' => 'equipment_component_id'])->via('equipmentComponentParts');
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['id' => 'equipment_id'])->via('equipmentComponents');
    }

    public function getOrganizationStatus()
    {
        $organizationStatus = self::ORGANIZATION_STATUS_INACTIVE;
        switch ($this->organization_status) {
            case self::ORGANIZATION_STATUS_ACTIVE:
                $organizationStatus = 'active';
                break;
            case self::ORGANIZATION_STATUS_INACTIVE:
                $organizationStatus = 'inactive';
                break;
            default:
                $organizationStatus = 'inactive';
                break;
        }

        return $organizationStatus;
    }
}
