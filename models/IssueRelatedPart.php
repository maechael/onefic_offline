<?php

namespace app\models;

use PDO;
use Yii;

/**
 * This is the model class for table "issue_related_part".
 *
 * @property int $id
 * @property int $equipment_issue_id
 * @property int $component_part_id
 * @property int $type
 *
 * @property EquipmentIssue $equipmentIssue
 */
class IssueRelatedPart extends \yii\db\ActiveRecord
{
    const TYPE_COMPONENT = 1;
    const TYPE_PART = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'issue_related_part';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_issue_id', 'component_part_id', 'type'], 'required'],
            [['equipment_issue_id', 'component_part_id', 'type'], 'integer'],
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
            'component_part_id' => 'Component Part ID',
            'type' => 'Type',
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

    public function getPart()
    {
        return $this->hasOne(Part::class, ['id' => 'component_part_id']);
    }

    public function getComponent()
    {
        return $this->hasOne(Component::class, ['id' => 'component_part_id']);
    }
}
