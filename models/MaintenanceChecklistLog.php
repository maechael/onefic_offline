<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "maintenance_checklist_log".
 *
 * @property int $id
 * @property string $global_id
 * @property int $fic_equipment_id
 * @property string $accomplished_by_name
 * @property string $accomplished_by_designation
 * @property string $accomplished_by_office
 * @property string|null $accomplished_by_date
 * @property string $endorsed_by_name
 * @property string $endorsed_by_designation
 * @property string $endorsed_by_office
 * @property string|null $endorsed_by_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ChecklistCriteria[] $checklistCriterias
 * @property FicEquipment $ficEquipment
 */
class MaintenanceChecklistLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maintenance_checklist_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_equipment_id', 'accomplished_by_name', 'accomplished_by_designation', 'accomplished_by_office', 'endorsed_by_name', 'endorsed_by_designation', 'endorsed_by_office'], 'required'],
            [['fic_equipment_id'], 'integer'],
            [['accomplished_by_date', 'endorsed_by_date', 'created_at', 'updated_at'], 'safe'],
            [['accomplished_by_name', 'accomplished_by_designation', 'endorsed_by_name', 'endorsed_by_designation'], 'string', 'max' => 128],
            [['accomplished_by_office', 'endorsed_by_office', 'global_id'], 'string', 'max' => 255],
            [['fic_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => FicEquipment::class, 'targetAttribute' => ['fic_equipment_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fic_equipment_id' => 'Fic Equipment ID',
            'accomplished_by_name' => 'Name',
            'accomplished_by_designation' => 'Designation',
            'accomplished_by_office' => 'Office',
            'accomplished_by_date' => 'Date',
            'endorsed_by_name' => 'Name',
            'endorsed_by_designation' => 'Designation',
            'endorsed_by_office' => 'Office',
            'endorsed_by_date' => 'Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ChecklistCriterias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChecklistCriterias()
    {
        return $this->hasMany(ChecklistCriteria::class, ['maintenance_checklist_log_id' => 'id']);
    }

    /**
     * Gets query for [[FicEquipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicEquipment()
    {
        return $this->hasOne(FicEquipment::class, ['id' => 'fic_equipment_id']);
    }

    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_id'])->via('ficEquipment');
    }
}
