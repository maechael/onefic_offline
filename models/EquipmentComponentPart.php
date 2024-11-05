<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_component_part".
 *
 * @property int $id
 * @property int $equipment_component_id
 * @property int $part_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentComponent $equipmentComponent
 * @property Part $part
 */
class EquipmentComponentPart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_component_part';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_component_id', 'part_id'], 'required'],
            [['equipment_component_id', 'part_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['equipment_component_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentComponent::className(), 'targetAttribute' => ['equipment_component_id' => 'id']],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => Part::className(), 'targetAttribute' => ['part_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipment_component_id' => 'Equipment Component ID',
            'part_id' => 'Part ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentComponent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponent()
    {
        return $this->hasOne(EquipmentComponent::className(), ['id' => 'equipment_component_id']);
    }

    /**
     * Gets query for [[Part]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(Part::className(), ['id' => 'part_id']);
    }
}
