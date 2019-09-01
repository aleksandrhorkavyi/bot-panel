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
    private $command = null;

    private $answer = null;

    public function __construct(Command $command)
    {
        $this->setCommand($command);
    }

    public function sendMenu()
    {
        $this->answer = 'Send menu';

        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->command->chatID,
            'text' => $this->answer,
        ]);
    }

    public function sendMat()
    {
        $this->answer = 'Send mat';

        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->command->chatID,
            'text' => $this->answer,
        ]);
    }

    public function handle()
    {
        if (empty($this->command->text) OR !in_array($this->command->text, $this->allowedCommands)) {
            $this->answer = Json::encode($this->command);
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
     * @return null
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