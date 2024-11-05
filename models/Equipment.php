<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment".
 *
 * @property int $id
 * @property string $model
 * @property int $equipment_type_id
 * @property int $equipment_category_id
 * @property int $processing_capability_id
 * @property int|null $image_id
 * @property int|null $isDeleted
 * @property int|null $version
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentCategory $equipmentCategory
 * @property EquipmentComponent[] $equipmentComponents
 * @property EquipmentType $equipmentType
 * @property Media $image
 * @property ProcessingCapability $processingCapability
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'equipment_type_id', 'equipment_category_id', 'processing_capability_id'], 'required'],
            [['equipment_type_id', 'equipment_category_id', 'processing_capability_id', 'image_id', 'isDeleted', 'version'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['model'], 'string', 'max' => 200],
            [['model'], 'unique'],
            [['equipment_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentCategory::class, 'targetAttribute' => ['equipment_category_id' => 'id']],
            [['equipment_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentType::class, 'targetAttribute' => ['equipment_type_id' => 'id']],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Media::class, 'targetAttribute' => ['image_id' => 'id']],
            [['processing_capability_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProcessingCapability::class, 'targetAttribute' => ['processing_capability_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'equipment_type_id' => 'Equipment Type ID',
            'equipment_category_id' => 'Equipment Category ID',
            'processing_capability_id' => 'Processing Capability ID',
            'image_id' => 'Image ID',
            'isDeleted' => 'Is Deleted',
            'version' => 'Version',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentCategory()
    {
        return $this->hasOne(EquipmentCategory::class, ['id' => 'equipment_category_id']);
    }

    /**
     * Gets query for [[EquipmentSpecs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentSpecs()
    {
        return $this->hasMany(EquipmentSpec::class, ['equipment_id' => 'id']);
    }

    /**
     * Gets query for [[EquipmentComponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['equipment_id' => 'id']);
    }

    public function getComponents()
    {
        return $this->hasMany(Component::class, ['id' => 'component_id'])->via('equipmentComponents');
    }

    public function getEquipmentComponentParts()
    {
        return $this->hasMany(EquipmentComponentPart::class, ['equipment_component_id' => 'id'])->via('equipmentComponents');
    }

    public function getParts()
    {
        return $this->hasMany(Part::class, ['id' => 'part_id'])->via('equipmentComponentParts');
    }

    /**
     * Gets query for [[EquipmentType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentType()
    {
        return $this->hasOne(EquipmentType::class, ['id' => 'equipment_type_id']);
    }

    /**
     * Gets query for [[Image]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Media::class, ['id' => 'image_id']);
    }

    /**
     * Gets query for [[ProcessingCapability]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProcessingCapability()
    {
        return $this->hasOne(ProcessingCapability::class, ['id' => 'processing_capability_id']);
    }

    public function getEquipmentTechServices()
    {
        return $this->hasMany(EquipmentTechService::class, ['equipment_id' => 'id']);
    }

    public function getTechServices()
    {
        return $this->hasMany(TechService::class, ['id' => 'tech_service_id'])->via('equipmentTechServices');
    }

    public function getFicEquipments()
    {
        return $this->hasMany(FicEquipment::class, ['equipment_id' => 'id']);
    }

    public function getChecklistComponentTemplates()
    {
        return $this->hasMany(ChecklistComponentTemplate::class, ['equipment_id' => 'id']);
    }

    public static function getEquipments()
    {
        return self::find()->orderBy(['model' => SORT_ASC])->all();
    }

    public static function getEquipmentsByFicId($id)
    {
        return self::find()->joinWith('ficEquipments')->where(['{{%fic_equipment}}.fic_id' => $id])->all();
    }

    public static function getFicEquipmentsById($id)
    {
        return self::find()->joinWith('ficEquipments')->where(['fic_id' => $id])->all();
    }
}
