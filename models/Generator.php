<?php

namespace app\models;

use app\models\enums\SizeCodeEnum;
use Yii;
use yii\base\Model;
use yii\helpers\FileHelper;

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
        $pathCacheBig = Yii::getAlias('@webroot') . self::PATH_CACHE_BIG;
        $pathCacheMin = Yii::getAlias('@webroot') . self::PATH_CACHE_MIN;
        if(file_exists($path)) {
            switch ($sizeCode) {
                case SizeCodeEnum::BIG:
                    if(!file_exists($pathCacheBig)) {
                        FileHelper::createDirectory($pathCacheBig, 0755);
                    }
                    $pathCache = $pathCacheBig . "/$name.jpg";
                    if(!file_exists($pathCache)) {
                        if(!$this->resize($path, $pathCache, $sizeCode)) {
                            Yii::$app->session->setFlash('error', 'Image settings are not set');
                            return '';
                        }
                    }
                    return Yii::getAlias('@web') . self::PATH_CACHE_BIG . "/$name.jpg";
                case SizeCodeEnum::MIN:
                    if(!file_exists($pathCacheMin)) {
                        FileHelper::createDirectory($pathCacheMin, 0755);
                    }
                    $pathCache = $pathCacheMin . "/$name.jpg";
                    if(!file_exists($pathCache)) {
                        if(!$this->resize($path, $pathCache, $sizeCode)) {
                            Yii::$app->session->setFlash('error', 'Image settings are not set');
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
        if(empty($newWidth) || empty($newHeight)) {
            return false;
        }
        $image->thumbnailImage($newWidth, $newHeight, true);

        $isSaved =  $image->writeImage($pathCache);
        $image->clear();
        $image->destroy();

        return $isSaved;
    }

}