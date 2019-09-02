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
        $this->answer = \Yii::$app->params['settings']['trash_message'];
        $this->saveCanceledToken();
        Yii::$app->telegram->answerCallbackQuery([
            'callback_query_id' => $this->getCommand()->callbackID,
            'text' => $this->answer,
            'show_alert' => 'Ok',
        ]);
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    protected function saveCanceledToken()
    {
        $proto_id = $this->getCommand()->callbackData['token_id'];

        if ($tokenPrototype = TokenAccepted::findOne(['proto_id' => $proto_id])) {
            $token = new TokenCanceled(['value' => $tokenPrototype->value]);
            $token->save();
            $tokenPrototype->delete();
            $this->answer = \Yii::$app->params['settings']['trash_message'];
            return true;
        }
        $this->answer = \Yii::$app->params['settings']['trash_message_already'];
    }

}