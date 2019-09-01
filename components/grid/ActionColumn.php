<?php

namespace app\components\grid;

use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = '{delete}';
}