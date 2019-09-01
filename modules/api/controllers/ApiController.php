<?php

namespace app\modules\api\controllers;

use yii\web\Controller;

/**
 * Panel controller for the `api` module
 */
class ApiController extends Controller
{
    public function actionTokens()
    {
        return Yii::$app->telegram->sendMessage([
            'chat_id' => '354632391',
            'text' => 'test',
        ]);
        return $this->asJson(['status' => 'ok']);
    }

}
