<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "checklist_criteria".
 *
 * @property int $id
 * @property int $maintenance_checklist_log_id
 * @property int|null $equipment_component_id
 * @property string $component_name
 * @property string $criteria
 * @property int|null $result
 * @property string|null $remarks
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentComponent $equipmentComponent
 * @property MaintenanceChecklistLog $maintenanceChecklistLog
 */
class ChecklistCriteria extends \yii\db\ActiveRecord
{
    const RESULT_YES = true;
    const RESULT_NO = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'checklist_criteria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['maintenance_checklist_log_id', 'component_name', 'criteria'], 'required'],
            [['maintenance_checklist_log_id', 'equipment_component_id', 'result'], 'integer'],
            [['criteria', 'remarks'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['component_name'], 'string', 'max' => 255],
            [['equipment_component_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentComponent::class, 'targetAttribute' => ['equipment_component_id' => 'id']],
            [['maintenance_checklist_log_id'], 'exist', 'skipOnError' => true, 'targetClass' => MaintenanceChecklistLog::class, 'targetAttribute' => ['maintenance_checklist_log_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'maintenance_checklist_log_id' => 'Maintenance Checklist Log ID',
            'equipment_component_id' => 'Equipment Component ID',
            'component_name' => 'Component Name',
            'criteria' => 'Criteria',
            'result' => 'Result',
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
     * Gets query for [[MaintenanceChecklistLog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaintenanceChecklistLog()
    {
        return $this->hasOne(MaintenanceChecklistLog::class, ['id' => 'maintenance_checklist_log_id']);
    }
}
