<?php

namespace app\modules\api\components;

use app\modules\panel\models\TokenAccepted;
use app\modules\panel\models\TokenActive;
use Yii;
use yii\helpers\Json;

class CommandHandler
{
    public $allowedCommands = [
        'мат' => 'runMatCommand',
        'не раб' => 'runMatCommand',
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


    public function runMatCommand()
    {
        $nextToken = $this->getNextToken();
        $this->answer = $nextToken->value;

        Yii::$app->telegram->sendMessage([
            'chat_id' => $this->command->chatID,
            'text' => $this->answer,
            'reply_markup' => json_encode([
                'inline_keyboard'=>[
                    [
                        [
                            'text'=> 'trash',
                            'callback_data'=> Json::encode([
                                'key' => 'trash',
                                'token_id' => $nextToken->id
                            ])
                        ],
                    ]
                ]
            ]),
        ]);
    }


    /**
     * @return TokenActive
     */
    public function getNextToken(): TokenActive
    {
        $nextToken = TokenActive::find()->orderBy(['id' => SORT_ASC])->one();
        if ($nextToken) {
            $token = new TokenAccepted([
                'proto_id' => $nextToken->id,
                'value' => $nextToken->value
            ]);
            $token->save();
            $nextToken->delete();
        } else {
            $token = new TokenActive(['value' => 'I am empty :(']);
        }

        return $token;
    }

    public function handle()
    {
        $key = ($this->getCommand()->type === Command::TYPE_CALLBACK_QUERY) ?
            $this->getCommand()->callbackData['key'] : $this->getCommand()->text;

        if (empty($this->allowedCommands[$key])) {
            $this->answer = 'Undefined command';
            Yii::$app->telegram->sendMessage([
                'chat_id' => $this->command->chatID,
                'text' => $this->answer,
            ]);
            return false;
        }
        call_user_func_array([$this, $this->allowedCommands[$key]], []);
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