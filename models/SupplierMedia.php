<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "supplier_media".
 *
 * @property int $id
 * @property int|null $supplier_id
 * @property int|null $branch_id
 * @property int|null $media_id
 * @property string|null $media_type
 *
 * @property Branch $branch
 * @property Metadata $media
 * @property Supplier $supplier
 */
class SupplierMedia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supplier_id', 'branch_id', 'media_id'], 'integer'],
            [['media_type'], 'string', 'max' => 255],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['media_id'], 'exist', 'skipOnError' => true, 'targetClass' => Metadata::className(), 'targetAttribute' => ['media_id' => 'id']],
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
            'supplier_id' => 'Supplier ID',
            'branch_id' => 'Branch ID',
            'media_id' => 'Media ID',
            'media_type' => 'Media Type',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Media]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMedia()
    {
        return $this->hasOne(Metadata::className(), ['id' => 'media_id']);
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
