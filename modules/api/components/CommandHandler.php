<?php

namespace app\modules\api\components;

use app\modules\panel\models\TokenAccepted;
use app\modules\panel\models\TokenActive;
use Yii;
use yii\db\ActiveRecord;
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
        if ($nextToken) {
            $this->answer = $nextToken->value;
            Yii::$app->telegram->sendMessage([
                'chat_id' => $this->command->chatID,
                'text' => $this->answer,
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [
                            [
                                'text' => 'trash',
                                'callback_data' => Json::encode([
                                    'key' => 'trash',
                                    'token_id' => $nextToken->proto_id
                                ])
                            ],
                        ]
                    ]
                ]),
            ]);
        } else {
            Yii::$app->telegram->sendMessage([
                'chat_id' => $this->command->chatID,
                'text' => $this->answer,
            ]);
        }
    }


    /**
     * @return TokenAccepted|TokenActive
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function getNextToken()
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
            $this->answer = 'Я полностью опустошен :(';
            return false;
        }

        return $token;
    }

    public function handle()
    {
        $key = ($this->getCommand()->type === Command::TYPE_CALLBACK_QUERY) ?
            $this->getCommand()->callbackData['key'] : $this->getCommand()->text;

        if (empty($this->allowedCommands[$key])) {
//            $this->answer = 'Undefined command';
//            Yii::$app->telegram->sendMessage([
//                'chat_id' => $this->command->chatID,
//                'text' => $this->answer,
//            ]);
            return true;
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