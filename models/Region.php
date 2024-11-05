<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property int $number
 * @property string $code
 * @property string|null $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property MunicipalityCity[] $municipalityCities
 * @property Province[] $provinces
 * @property Supplier[] $suppliers
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'code'], 'required'],
            [['number'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'name'], 'string', 'max' => 100],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'code' => 'Code',
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
        return $this->hasMany(MunicipalityCity::className(), ['region_id' => 'id']);
    }

    /**
     * Gets query for [[Provinces]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvinces()
    {
        return $this->hasMany(Province::className(), ['region_id' => 'id']);
    }

    /**
     * Gets query for [[Suppliers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSuppliers()
    {
        return $this->hasMany(Supplier::className(), ['region_id' => 'id']);
    }

    public static function getRegions()
    {
        return self::find()->all();
    }
}
