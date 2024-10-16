<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg', 'maxFiles' => 10],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $file->saveAs(\Yii::getAlias('@webroot') . Generator::PATH_GALLERY . DIRECTORY_SEPARATOR
                    . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}