<?php

/** @var yii\web\View $this */
/** @var array $files */
/** @var \app\models\Generator $generator */
/** @var \app\models\UploadForm $uploadForm */

use yii\widgets\ActiveForm;
use app\models\enums\SizeCodeEnum;

$this->title = 'My Yii Application';

$items = [];
foreach ($files as $file) {
    $name = explode('.', $file)[0];
    $items[] = [
        'url' => $generator->resizeImage($name, SizeCodeEnum::BIG),
        'src' => $generator->resizeImage($name, SizeCodeEnum::MIN),
        'options' => array('title' => $name, 'class' => 'aligned-item', 'style' => 'width: ' . SizeCodeEnum::MIN->values()['width'] . 'px;')
    ];
}
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

        <?= $form->field($uploadForm, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

        <button class="btn btn-primary">Submit</button>

        <?php ActiveForm::end() ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <h2>Gallery</h2>
                <?= dosamigos\gallery\Gallery::widget(['items' => $items]);?>
            </div>
        </div>

    </div>
</div>
