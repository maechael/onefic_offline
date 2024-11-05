<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "local_media".
 *
 * @property int $id
 * @property string $basename
 * @property string $filename
 * @property string $filepath
 * @property string $type
 * @property int $size
 * @property string $extension
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EquipmentIssueImage[] $equipmentIssueImages
 */
class LocalMedia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'local_media';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['basename', 'filename', 'filepath', 'type', 'size', 'extension'], 'required'],
            [['size'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['basename', 'filename', 'filepath'], 'string', 'max' => 255],
            [['type', 'extension'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'basename' => 'Basename',
            'filename' => 'Filename',
            'filepath' => 'Filepath',
            'type' => 'Type',
            'size' => 'Size',
            'extension' => 'Extension',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[EquipmentIssueImages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentIssueImages()
    {
        return $this->hasMany(EquipmentIssueImage::class, ['local_media_id' => 'id']);
    }

    public function getLink()
    {
        return Url::to('@web/') . $this->filepath;
    }

    public function deleteMedia()
    {
        if (file_exists($this->filepath))
            unlink($this->filepath);
        $this->delete();
    }

    public function set($file, $subfolder = null)
    {
        $hashedName = uniqid(rand(), true) . "." . $file->extension;
        $filePath = isset($subfolder) ? Yii::$app->params["base_upload_folder"] . "/" . $subfolder . "/" . $hashedName : Yii::$app->params["base_upload_folder"] . "/" . $hashedName;

        $this->basename = $file->name;
        $this->filename = $hashedName;
        $this->filepath = $filePath;
        $this->type = $file->type;
        $this->extension = $file->extension;
        $this->size = $file->size;
    }

    public function upload($file)
    {
        if (!is_dir(dirname($this->filepath)))
            FileHelper::createDirectory(dirname($this->filepath));
        return $file->saveAs($this->filepath);
    }

    public function getPreviewType()
    {
        $previewType = "pdf";
        switch ($this->extension) {
            case "pdf":
                $previewType = "pdf";
                break;
            case "png" | "jpg" | "jpeg":
                $previewType = "image";
                break;
            default:
                $previewType = "image";
        }
        return $previewType;
    }
}
