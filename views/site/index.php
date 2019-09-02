<?php

/* @var $this yii\web\View */
/* @var $model Settings */

use app\models\Settings;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Bot panel';
?>
<div class="site-index">

    <h2>Bot settings</h2>
    <?php $form = ActiveForm::begin(['id' => 'settings-form'])?>

    <?= $form->field($model, 'bot_token')->textInput(); ?>
    <?= $form->field($model, 'commands')->textInput(); ?>
    <?= $form->field($model, 'hello_message')->textInput(); ?>
    <?= $form->field($model, 'empty_message')->textInput(); ?>
    <?= $form->field($model, 'trash_message')->textInput(); ?>
    <?= $form->field($model, 'trash_message_already')->textInput(); ?>
    <hr>
    <?= $form->field($model, 'username')->textInput(['autocomplete' => 'off']); ?>
    <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'off']); ?>

    <div class="form-group">
        <?= Html::button('Update', ['type' => 'submit', 'class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end()?>

</div>
