<?php

namespace app\models;

use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii2tech\ar\softdelete\SoftDeleteQueryBehavior;

/**
 * This is the model class for table "fic_equipment".
 *
 * @property int $id
 * @property string $global_id
 * @property int|null $fic_id
 * @property int $equipment_id
 * @property string $serial_number
 * @property int $status
 * @property string|null $remarks
 * @property bool $isDeleted
 * @property int $version
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Equipment $equipment
 * @property EquipmentIssue[] $equipmentIssues
 * @property EquipmentMaintenanceLog[] $equipmentMaintenanceLogs
 * @property Fic $fic
 */
class FicEquipment extends \yii\db\ActiveRecord
{
    const STATUS_SERVICEABLE = 1;
    const STATUS_UNSERVICEABLE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic_equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_id', 'equipment_id', 'status'], 'integer'],
            [['equipment_id', 'serial_number'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['remarks'], 'string'],
            [['serial_number'], 'string', 'max' => 100],
            [['serial_number'], 'unique'],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fic_id' => 'Fic ID',
            'equipment_id' => 'Equipment Model',
            'serial_number' => 'Serial Number',
            'status' => 'Status',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors()
    {
        return [
            'softDeleteBehavior' => [
                'class' => SoftDeleteBehavior::class,
                'softDeleteAttributeValues' => [
                    'isDeleted' => true
                ],
            ]
        ];
    }

    public static function find()
    {
        $query = parent::find();
        $query->attachBehavior('softDelete', SoftDeleteQueryBehavior::class);

        return $query->notDeleted();
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

    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['equipment_id' => 'id'])->via('equipment');
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
     * Gets query for [[EquipmentIssues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentIssues()
    {
        return $this->hasMany(EquipmentIssue::class, ['fic_equipment_id' => 'id']);
    }

    public function getIssueCount()
    {
        return $this->getEquipmentIssues()->count();
    }

    /**
     * Gets query for [[EquipmentMaintenanceLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentMaintenanceLogs()
    {
        return $this->hasMany(EquipmentMaintenanceLog::class, ['fic_equipment_id' => 'id']);
    }

    /**
     * Gets query for [[Fic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_id']);
    }

    /**
     * Gets query for [[FicEquipmentStatusHistory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicEquipmentStatusHistory()
    {
        return $this->hasMany(FicEquipmentStatusHistory::class, ['fic_equipment_id' => 'id'])->orderBy(['created_at' => SORT_DESC]);
    }

    public function getMaintenanceChecklistLogs()
    {
        return $this->hasMany(MaintenanceChecklistLog::class, ['fic_equipment_id' => 'id']);
    }

    public function getChecklistComponentTemplates()
    {
        return $this->hasMany(ChecklistComponentTemplate::class, ['equipment_id' => 'id'])->via('equipment');
    }

    public static function getFicEquipmentsById($id)
    {
        return self::find()->where(['fic_id' => $id])->all();
    }

    public function getEquipmentStatus()
    {
        $statusDisplay = 'Serviceable';
        switch ($this->status) {
            case self::STATUS_SERVICEABLE:
                $statusDisplay = 'Serviceable';
                break;
            case self::STATUS_UNSERVICEABLE:
                $statusDisplay = 'Unserviceable';
            default:
                # code...
                break;
        }
        return $statusDisplay;
    }
}
