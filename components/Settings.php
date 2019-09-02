<?php

namespace app\components;


class Settings
{
    public function __construct()
    {
        $this->initSettings();
    }

    public function initSettings()
    {
        $settings = \app\models\Settings::find()->one();
        \Yii::$app->params['settings'] = $settings->attributes;
    }
}