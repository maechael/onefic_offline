<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property int $id
 * @property int $region_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MunicipalityCity[] $municipalityCities
 * @property Region $region
 * @property Supplier[] $suppliers
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id', 'name'], 'required'],
            [['region_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Region ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[MunicipalityCities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalityCities()
    {
        return $this->hasMany(MunicipalityCity::className(), ['province_id' => 'id']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    /**
     * Gets query for [[Suppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuppliers()
    {
        return $this->hasMany(Supplier::className(), ['province_id' => 'id']);
    }
}
