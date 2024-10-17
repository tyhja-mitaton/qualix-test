<?php

namespace app\models;

use yii\base\Model;

class GeneratorSettings extends Model
{
    public int $max_width, $max_height, $min_width, $min_height;

    public function rules()
    {
        return [
            [['max_width', 'max_height', 'min_width', 'min_height'], 'required'],
            [['max_width', 'max_height', 'min_width', 'min_height'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'max_width' => 'Big width',
            'max_height' => 'Big height',
            'min_width' => 'Min width',
            'min_height' => 'Min height',
        ];
    }

    public function fields()
    {
        return ['max_width', 'max_height', 'min_width', 'min_height'];
    }

    public function attributes()
    {
        return ['max_width', 'max_height', 'min_width', 'min_height'];
    }

}