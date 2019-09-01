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
        $command = new Command(Json::decode($body));
        $handler = new CommandHandler($command);
        $handler->handle();

        return $this->asJson(['status' => 'ok']);
    }

}
