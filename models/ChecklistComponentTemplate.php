<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist_component_template".
 *
 * @property int $id
 * @property int|null $equipment_id
 * @property int|null $equipment_component_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CriteriaTemplate[] $criteriaTemplates
 * @property Equipment $equipment
 * @property EquipmentComponent $equipmentComponent
 */
class ChecklistComponentTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'checklist_component_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_id', 'equipment_component_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['equipment_component_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentComponent::class, 'targetAttribute' => ['equipment_component_id' => 'id']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipment_id' => 'Equipment ID',
            'equipment_component_id' => 'Equipment Component ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CriteriaTemplates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCriteriaTemplates()
    {
        return $this->hasMany(CriteriaTemplate::class, ['checklist_component_template_id' => 'id']);
    }

    public function getCriteriaTemplatesCount()
    {
        return $this->getCriteriaTemplates()->count();
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment()
    {
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id']);
    }

    /**
     * Gets query for [[EquipmentComponent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponent()
    {
        return $this->hasOne(EquipmentComponent::class, ['id' => 'equipment_component_id']);
    }

    public function getComponent()
    {
        return $this->hasOne(Component::class, ['id' => 'component_id'])->via('equipmentComponent');
    }
}
