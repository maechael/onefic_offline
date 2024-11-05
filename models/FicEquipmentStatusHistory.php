<?php

namespace app\models;

use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "fic_equipment_status_history".
 *
 * @property int $id
 * @property int $fic_equipment_id
 * @property int $status
 * @property string|null $remarks
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $createdBy
 * @property FicEquipment $ficEquipment
 * @property User $updatedBy
 */
class FicEquipmentStatusHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic_equipment_status_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_equipment_id', 'status'], 'required'],
            [['fic_equipment_id', 'status', 'created_by', 'updated_by'], 'integer'],
            [['remarks'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['fic_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => FicEquipment::class, 'targetAttribute' => ['fic_equipment_id' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::class,
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
            'status' => 'Status',
            'remarks' => 'Remarks',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
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

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
