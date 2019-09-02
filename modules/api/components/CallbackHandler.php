<?php


namespace app\modules\api\components;

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
        $this->answer = 'callbackTrash';

        Yii::$app->telegram->answerCallbackQuery([
            'callback_query_id' => $this->getCommand()->callbackID,
            'text' => $this->answer,
            'show_alert' => 'my alert',  //Optional
//            'url' => 'http://sample.com', //Optional
//            'cache_time' => 123231,  //Optional
        ]);
    }

//    public function handle()
//    {
//        if (empty($this->allowedCommands[$this->command->text])) {
//            $this->answer = 'Undefined callback';
//            Yii::$app->telegram->sendMessage([
//                'chat_id' => $this->command->chatID,
//                'text' => $this->answer,
//            ]);
//            return false;
//        }
//        call_user_func_array([$this, $this->allowedCommands[$this->command->text]], []);
//        return true;
//    }
}