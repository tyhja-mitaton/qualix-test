<?php

namespace app\models;

use app\models\enums\SizeCodeEnum;
use Yii;
use yii\base\Model;

class Generator extends Model
{
    const PATH_GALLERY = '/images/gallery';
    const PATH_CACHE_BIG = '/images/cache/big';
    const PATH_CACHE_MIN = '/images/cache/min';

    /**
     * @param string $name
     * @param SizeCodeEnum $sizeCode
     *
     * @return string
     */
    public function resizeImage($name, SizeCodeEnum $sizeCode)
    {
        $path = Yii::getAlias('@webroot') . self::PATH_GALLERY . "/$name.jpg";
        if(file_exists($path)) {
            switch ($sizeCode) {
                case SizeCodeEnum::BIG:
                    $pathCache = Yii::getAlias('@webroot') . self::PATH_CACHE_BIG . "/$name.jpg";
                    if(!file_exists($pathCache)) {
                        if(!$this->resize($path, $pathCache, $sizeCode)) {
                            return '';
                        }
                    }
                    return Yii::getAlias('@web') . self::PATH_CACHE_BIG . "/$name.jpg";
                case SizeCodeEnum::MIN:
                    $pathCache = Yii::getAlias('@webroot') . self::PATH_CACHE_MIN . "/$name.jpg";
                    if(!file_exists($pathCache)) {
                        if(!$this->resize($path, $pathCache, $sizeCode)) {
                            return '';
                        }
                    }
                    return Yii::getAlias('@web') . self::PATH_CACHE_MIN . "/$name.jpg";
            }
        }
        return '';
    }

    /**
     * Resizes an image by a given size code.
     *
     * @param string $path the path to the original image
     * @param string $pathCache the path to where the resized image should be saved
     * @param SizeCodeEnum $sizeCode the size code to use for resizing
     *
     * @return bool whether the resizing was successful
     */
    private function resize(string $path, string $pathCache, SizeCodeEnum $sizeCode): bool
    {
        $image = new \Imagick($path);
        list($newWidth, $newHeight) = [$sizeCode->values()['width'], $sizeCode->values()['height']];
        $image->thumbnailImage($newWidth, $newHeight, true);

        $isSaved =  $image->writeImage($pathCache);
        $image->clear();
        $image->destroy();

        return $isSaved;
    }

}