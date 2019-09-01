<?php

namespace app\modules\api\controllers;

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

    public function actionHandleCommand()
    {
        $body = Yii::$app->request->rawBody;

        $content = new CommandHandler($body);

         Yii::$app->telegram->sendMessage([
            'chat_id' => '354632391',
            'text' => Json::encode($content),
        ]);

        return $this->asJson(['status' => 'ok']);
    }

}
