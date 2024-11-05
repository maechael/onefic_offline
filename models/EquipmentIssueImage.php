<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_issue_image".
 *
 * @property int $id
 * @property int $equipment_issue_id
 * @property int $local_media_id
 *
 * @property EquipmentIssue $equipmentIssue
 * @property LocalMedia $localMedia
 */
class EquipmentIssueImage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_issue_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_issue_id', 'local_media_id'], 'required'],
            [['equipment_issue_id', 'local_media_id'], 'integer'],
            [['equipment_issue_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentIssue::class, 'targetAttribute' => ['equipment_issue_id' => 'id']],
            [['local_media_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocalMedia::class, 'targetAttribute' => ['local_media_id' => 'id']],
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
            'local_media_id' => 'Local Media ID',
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

    /**
     * Gets query for [[LocalMedia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalMedia()
    {
        return $this->hasOne(LocalMedia::class, ['id' => 'local_media_id']);
    }
}
