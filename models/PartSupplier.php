<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "part_supplier".
 *
 * @property int $id
 * @property int $part_id
 * @property int $supplier_id
 *
 * @property Part $part
 * @property Supplier $supplier
 */
class PartSupplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'part_supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['part_id', 'supplier_id'], 'required'],
            [['part_id', 'supplier_id'], 'integer'],
            [['part_id', 'supplier_id'], 'unique', 'targetAttribute' => ['part_id', 'supplier_id']],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => Part::className(), 'targetAttribute' => ['part_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'part_id' => 'Part ID',
            'supplier_id' => 'Supplier ID',
        ];
    }

    /**
     * Gets query for [[Part]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPart()
    {
        return $this->hasOne(Part::className(), ['id' => 'part_id']);
    }

    /**
     * Gets query for [[Supplier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }
}
