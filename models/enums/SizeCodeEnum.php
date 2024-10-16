<?php

namespace app\models\enums;

enum SizeCodeEnum: string
{

    case MIN = 'min';
    case BIG = 'big';

    public function values():array
    {
        $settings = \Yii::$app->settings;
        return match ($this) {
            self::MIN => [
                'width' => $settings->get('GeneratorSettings.min_width'),
                'height' => $settings->get('GeneratorSettings.min_height'),],
            self::BIG => [
                'width' => $settings->get('GeneratorSettings.max_width'),
                'height' => $settings->get('GeneratorSettings.max_height'),],
        };
    }

}
