<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maintenance_log_component_part".
 *
 * @property int $id
 * @property int $equipment_maintenance_log_id
 * @property int $equipment_component_id
 * @property int|null $equipment_component_part_id
 * @property int|null $isInspected
 * @property int|null $isOperational
 * @property string|null $remarks
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentComponent $equipmentComponent
 * @property EquipmentComponentPart $equipmentComponentPart
 * @property EquipmentMaintenanceLog $equipmentMaintenanceLog
 */
class MaintenanceLogComponentPart extends \yii\db\ActiveRecord
{
    const IS_OPERATIONAL_YES = 1;
    const IS_OPERATIONAL_NO = 0;

    const IS_INSPECTED_YES = 1;
    const IS_INSPECTED_NO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maintenance_log_component_part';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_maintenance_log_id', 'equipment_component_id'], 'required'],
            [['equipment_maintenance_log_id', 'equipment_component_id', 'equipment_component_part_id', 'isInspected', 'isOperational'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['remarks'], 'string', 'max' => 255],
            [['equipment_component_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentComponent::class, 'targetAttribute' => ['equipment_component_id' => 'id']],
            [['equipment_component_part_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentComponentPart::class, 'targetAttribute' => ['equipment_component_part_id' => 'id']],
            [['equipment_maintenance_log_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentMaintenanceLog::class, 'targetAttribute' => ['equipment_maintenance_log_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipment_maintenance_log_id' => 'Equipment Maintenance Log ID',
            'equipment_component_id' => 'Equipment Component ID',
            'equipment_component_part_id' => 'Equipment Component Part ID',
            'isInspected' => 'Is Inspected',
            'isOperational' => 'Is Operational',
            'remarks' => 'Remarks',
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
        return $this->hasOne(EquipmentComponent::class, ['id' => 'equipment_component_id']);
    }

    /**
     * Gets query for [[EquipmentComponentPart]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponentPart()
    {
        return $this->hasOne(EquipmentComponentPart::class, ['id' => 'equipment_component_part_id']);
    }

    /**
     * Gets query for [[EquipmentMaintenanceLog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentMaintenanceLog()
    {
        return $this->hasOne(EquipmentMaintenanceLog::class, ['id' => 'equipment_maintenance_log_id']);
    }
}
