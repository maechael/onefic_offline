<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "spec_key".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentSpec[] $equipmentSpecs
 */
class SpecKey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spec_key';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentSpecs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentSpecs()
    {
        return $this->hasMany(EquipmentSpec::class, ['spec_key_id' => 'id']);
    }
}
