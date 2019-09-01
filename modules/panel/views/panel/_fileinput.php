<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'id' => 'file-form',
    'options' => ['enctype' => 'multipart/form-data'],
    'action' => Url::to(['file-upload']),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::to(['file-validate']),
]) ?>

<div class="file-input-container">
    <?= $form->field($model, 'file')->fileInput(['class' => 'form-control'])->label(false) ?>
    <div class="form-button">
        <?= Html::button(Yii::t('app', 'Upload'), [
            'class' => 'btn btn-default upload-btn',
            'type' => 'submit'
        ])?>
    </div>
</div>


<?php ActiveForm::end() ?>