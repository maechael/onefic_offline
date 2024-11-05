<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "criteria_template".
 *
 * @property int $id
 * @property int|null $checklist_component_template_id
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ChecklistComponentTemplate $checklistComponentTemplate
 */
class CriteriaTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'criteria_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['checklist_component_template_id'], 'integer'],
            [['description'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['checklist_component_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => ChecklistComponentTemplate::class, 'targetAttribute' => ['checklist_component_template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'checklist_component_template_id' => 'Checklist Component Template ID',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[ChecklistComponentTemplate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChecklistComponentTemplate()
    {
        return $this->hasOne(ChecklistComponentTemplate::class, ['id' => 'checklist_component_template_id']);
    }
}
