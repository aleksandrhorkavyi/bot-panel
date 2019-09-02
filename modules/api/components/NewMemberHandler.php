<?php


namespace app\modules\api\components;

use app\modules\panel\models\TokenAccepted;
use app\modules\panel\models\TokenCanceled;
use Yii;

/**
 * Class CallbackHandler
 * @package app\modules\api\components
 */
class NewMemberHandler extends CommandHandler
{
    public function handle()
    {
        $this->answer = 'Hi, bratishka!';
        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->command->chatID,
            'text' => $this->answer,
        ]);

        var_dump($this->answer);
    }

}