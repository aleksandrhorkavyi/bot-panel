<?php


namespace app\modules\api\components;

use app\modules\panel\models\TokenAccepted;
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
        Yii::$app->telegram->answerCallbackQuery([
            'callback_query_id' => $this->getCommand()->callbackID,
            'text' => $this->answer,
            'show_alert' => 'Okay.',
            'cache_time' => 123231,
        ]);
    }

    protected function saveCanceledToken()
    {
        $proto_id = $this->getCommand()->callbackData['token_id'];

        if ($tokenPrototype = TokenAccepted::findOne(['proto_id' => $proto_id])) {
            $token = new TokenCanceled(['value' => $tokenPrototype->value]);
            $token->save();
            $tokenPrototype->delete();
            $this->answer = 'Canceled.';
            return true;
        }
        $this->answer = 'Already canceled.';
    }

}