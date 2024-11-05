<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fic_tech_service".
 *
 * @property int $id
 * @property int|null $fic_id
 * @property int|null $equipment_id
 * @property int|null $tech_service_id
 * @property string|null $charging_type
 * @property float|null $charging_fee
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Equipment $equipment
 * @property Fic $fic
 * @property TechService $techService
 */
class FicTechService extends \yii\db\ActiveRecord
{
    const CHARGE_TYPE_PER_DAY = 'PER DAY';
    const CHARGE_TYPE_PER_USE = 'PER USE';
    const CHARGE_TYPE_PER_HOUR = 'PER HOUR';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fic_tech_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fic_id', 'equipment_id', 'tech_service_id'], 'integer'],
            [['charging_fee'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['charging_type'], 'string', 'max' => 255],
            [['fic_id', 'equipment_id', 'tech_service_id', 'charging_type'], 'unique', 'targetAttribute' => ['fic_id', 'equipment_id', 'tech_service_id', 'charging_type']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
            [['fic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fic::class, 'targetAttribute' => ['fic_id' => 'id']],
            [['tech_service_id'], 'exist', 'skipOnError' => true, 'targetClass' => TechService::class, 'targetAttribute' => ['tech_service_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fic_id' => 'Fic ID',
            'equipment_id' => 'Equipment',
            'tech_service_id' => 'Tech Service',
            'charging_type' => 'Charging Type',
            'charging_fee' => 'Charging Fee',
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
     * Gets query for [[Fic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFic()
    {
        return $this->hasOne(Fic::class, ['id' => 'fic_id']);
    }

    /**
     * Gets query for [[TechService]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTechService()
    {
        return $this->hasOne(TechService::class, ['id' => 'tech_service_id']);
    }
}
