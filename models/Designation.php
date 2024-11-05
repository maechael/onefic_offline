<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "designation".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 */
class Designation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'designation';
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
            [['name'], 'string', 'max' => 255],
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

    public static function getDesignations()
    {
        return self::find()->orderBy(['name' => SORT_ASC])->all();
    }
}
