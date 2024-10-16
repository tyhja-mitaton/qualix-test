<?php
/**
 * @var $this yii\web\View
 * @var $model \app\models\GeneratorSettings
 */

$this->title = 'Settings';
?>

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Settings</h3>
            </div>
            <div class="card-body">
                <?php $form = \yii\widgets\ActiveForm::begin(['id' => 'settings-form']); ?>
                <?= $form->field($model, 'max_width')->textInput() ?>
                <?= $form->field($model, 'max_height')->textInput() ?>
                <?= $form->field($model, 'min_width')->textInput() ?>
                <?= $form->field($model, 'min_height')->textInput() ?>
                <div class="form-group">
                    <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                </div>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
