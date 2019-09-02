<?php


namespace app\modules\api\components;

use app\modules\panel\models\TokenCanceled;
use Yii;

/**
 * Class CallbackHandler
 * @package app\modules\api\components
 */
class CallbackHandler extends CommandHandler
{
    public $allowedCommands = [
        'trash' => 'callbackTrash',
    ];

    public function callbackTrash()
    {
        $this->answer = 'Okay.';
        $this->saveCanceledToken();
        $token = new TokenCanceled();
        $token->value = $this->getCommand()->callbackData['token'];
        $token->save();

        Yii::$app->telegram->answerCallbackQuery([
            'callback_query_id' => $this->getCommand()->callbackID,
            'text' => $this->answer,
            'show_alert' => 'Okay.',
            'cache_time' => 123231,
        ]);
    }

    protected function saveCanceledToken()
    {
        $value = $this->getCommand()->callbackData['token'];
        if (!TokenCanceled::find(['value' => $value])->exists()) {
            $token = new TokenCanceled(['value' => $value]);
            $token->save();
        }
        $this->answer = 'Already canceled.';
    }

}