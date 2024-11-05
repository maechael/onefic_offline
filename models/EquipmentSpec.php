<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipment_spec".
 *
 * @property int $id
 * @property int $equipment_id
 * @property int|null $spec_key_id
 * @property string|null $value
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Equipment $equipment
 * @property SpecKey $specKey
 */
class EquipmentSpec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipment_spec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipment_id'], 'required'],
            [['equipment_id', 'spec_key_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['value'], 'string', 'max' => 255],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
            [['spec_key_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpecKey::class, 'targetAttribute' => ['spec_key_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipment_id' => 'Equipment ID',
            'spec_key_id' => 'Spec Key ID',
            'value' => 'Value',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    /**
     * Gets query for [[SpecKey]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecKey()
    {
        return $this->hasOne(SpecKey::class, ['id' => 'spec_key_id']);
    }
}
