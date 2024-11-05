<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_issue_repair".
 *
 * @property int $id
 * @property int $equipment_issue_id
 * @property string $equipment_issue_gid
 * @property string $repair_activity
 * @property string $remarks
 * @property string $performed_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentIssue $equipmentIssue
 */
class EquipmentIssueRepair extends \yii\db\ActiveRecord
{
    public $issue_status;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_issue_repair';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_issue_id', 'repair_activity', 'performed_by'], 'required'],
            [['equipment_issue_id', 'issue_status'], 'integer'],
            [['repair_activity', 'remarks', 'equipment_issue_gid'], 'string'],
            [['created_at', 'updated_at', 'issue_status'], 'safe'],
            [['performed_by'], 'string', 'max' => 128],
            [['equipment_issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentIssue::class, 'targetAttribute' => ['equipment_issue_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipment_issue_id' => 'Equipment Issue ID',
            'repair_activity' => 'Repair Activity',
            'remarks' => 'Remarks',
            'performed_by' => 'Performed By',
            'issue_status' => 'Issue Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentIssue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentIssue()
    {
        return $this->hasOne(EquipmentIssue::class, ['id' => 'equipment_issue_id']);
    }
}
