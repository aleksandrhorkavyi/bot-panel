<?php

namespace app\modules\api\controllers;

use app\modules\api\components\CallbackHandler;
use app\modules\api\components\Command;
use app\modules\api\components\CommandHandler;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Panel controller for the `api` module
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionHook()
    {
        $body = Yii::$app->request->rawBody;
        $command = new Command(Json::decode($body));
        $handler = new CommandHandler($command);
        $handler->handle();

        return $this->asJson(['status' => 'ok']);
    }

    public function actionUpdates()
    {
        if (Yii::$app->session->has('bot_update_id')) {
            $offset = (int)Yii::$app->session->get('bot_update_id');
            $response = Yii::$app->telegram->getUpdates([
                'offset' => ++$offset,
                'limit' => 10,
                'timeout' => 5,
            ]);
            $data = Json::decode(Json::encode($response));

            foreach ($data['result'] as $message) {
                $command = new Command($message);
                if ($command->type === Command::TYPE_TEXT_MESSAGE) {
                    $handler = new CommandHandler($command);
                } else {
                    $handler = new CallbackHandler($command);
                }
                var_dump($message);
                var_dump($command);

                $handler->handle();
                Yii::$app->session->set('bot_update_id', $message['update_id']);
            }

            return $this->asJson(['status' => 'ok']);
        }
        return $this->asJson(['status' => 'fail']);
    }
}
