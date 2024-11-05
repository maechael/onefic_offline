<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facility".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property FicFacility[] $ficFacilities
 * @property Fic[] $fics
 */
class Facility extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'facility';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 150],
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
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[FicFacilities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicFacilities()
    {
        return $this->hasMany(FicFacility::class, ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[Fics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFics()
    {
        return $this->hasMany(Fic::class, ['id' => 'fic_id'])->via('ficFacilities');
    }
}
