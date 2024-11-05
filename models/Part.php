<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "part".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentComponentPart[] $equipmentComponentParts
 * @property PartSupplier[] $partSuppliers
 * @property Supplier[] $suppliers
 */
class Part extends \yii\db\ActiveRecord
{
    const SCENARIO_SYNC = 'sync';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'part';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SYNC] = [
            'id', 'name', 'isDeleted', 'version'
        ];

        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'name', 'isDeleted', 'version'], 'safe', 'on' => self::SCENARIO_SYNC],
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
     * Gets query for [[EquipmentComponentParts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponentParts()
    {
        return $this->hasMany(EquipmentComponentPart::class, ['part_id' => 'id']);
    }

    /**
     * Gets query for [[EquipmentComponents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentComponents()
    {
        return $this->hasMany(EquipmentComponent::class, ['id' => 'equipment_component_id'])->via('equipmentComponentParts');
    }

    /**
     * Gets query for [[Equipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipment::class, ['id' => 'equipment_id'])->via('equipmentComponents');
    }

    /**
     * Gets query for [[PartSuppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartSuppliers()
    {
        return $this->hasMany(PartSupplier::class, ['part_id' => 'id']);
    }

    /**
     * Gets query for [[Suppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuppliers()
    {
        return $this->hasMany(Supplier::class, ['id' => 'supplier_id'])->via('partSuppliers');
    }

    public static function getParts()
    {
        return self::find()->orderBy(['name' => SORT_ASC])->all();
    }
}
