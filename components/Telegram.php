<?php


namespace app\components;


class Telegram extends \aki\telegram\Telegram
{
    public function init()
    {
        /** @var \app\models\Settings $settings */
        $settings = \app\models\Settings::find()->one();
        $this->botToken = $settings->bot_token;

        parent::init();
    }
}