<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fic_service".
 *
 * @property int $fic_id
 * @property int $service_id
 *
 * @property Fic $fic
 * @property Service $service
 */
class FicService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_id', 'service_id'], 'required'],
            [['fic_id', 'service_id'], 'integer'],
            [['fic_id', 'service_id'], 'unique', 'targetAttribute' => ['fic_id', 'service_id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fic_id' => 'Fic ID',
            'service_id' => 'Service ID',
        ];
    }

    /**
     * Gets query for [[Fic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}
