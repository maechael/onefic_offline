<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FicService[] $ficServices
 * @property Fic[] $fics
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
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
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[FicServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFicServices()
    {
        return $this->hasMany(FicService::class, ['service_id' => 'id']);
    }

    /**
     * Gets query for [[Fics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFics()
    {
        return $this->hasMany(Fic::class, ['id' => 'fic_id'])->via('ficServices');
    }
}
