<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fic_facility".
 *
 * @property int $fic_id
 * @property int $facility_id
 *
 * @property Facility $facility
 * @property Fic $fic
 */
class FicFacility extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic_facility';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_id', 'facility_id'], 'required'],
            [['fic_id', 'facility_id'], 'integer'],
            [['fic_id', 'facility_id'], 'unique', 'targetAttribute' => ['fic_id', 'facility_id']],
            [['facility_id'], 'exist', 'skipOnError' => true, 'targetClass' => Facility::class, 'targetAttribute' => ['facility_id' => 'id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fic_id' => 'Fic ID',
            'facility_id' => 'Facility ID',
        ];
    }

    /**
     * Gets query for [[Facility]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFacility()
    {
        return $this->hasOne(Facility::class, ['id' => 'facility_id']);
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
}
