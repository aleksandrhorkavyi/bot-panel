<?php

namespace app\modules\api\components;

use Yii;
use yii\helpers\Json;

class CommandHandler
{
    public $allowedCommands = [
        '/menu' => 'sendMenu',
        '/mat' => 'sendMat'
    ];

    /**
     * @var Command
     */
    protected $command = null;

    protected $answer = null;

    public function __construct(Command $command)
    {
        $this->setCommand($command);
    }

    public function sendMenu()
    {
        $this->answer = 'trash';

        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->command->chatID,
            'text' => $this->answer,
            'reply_markup' => json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"Trash",'callback_data'=> time()]
                    ]
                ]
            ]),
        ]);
    }

    public function sendMat()
    {
        $this->answer = 'Trash';

        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->command->chatID,
            'text' => $this->answer,
        ]);
    }

    public function handle()
    {
        if (empty($this->allowedCommands[$this->command->text])) {
            $this->answer = 'Undefined command';
            Yii::$app->telegram->sendMessage([
                'chat_id' => $this->command->chatID,
                'text' => $this->answer,
            ]);
            return false;
        }
        call_user_func_array([$this, $this->allowedCommands[$this->command->text]], []);
        return true;
    }

    /**
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param $command
     */
    public function setCommand($command)
    {
        $this->command = $command;
    }
}