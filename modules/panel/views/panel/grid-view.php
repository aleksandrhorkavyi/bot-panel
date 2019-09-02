<?php

use app\components\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\panel\models\search\TokenSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $withFileInput boolean */

$this->title = Yii::t('app', 'Token');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="token-active-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($withFileInput): ?>
        <?= $this->render('_fileinput', ['model' => $model])?>
    <?php endif;?>
    <div id="preloader" class="load hidden">
        <hr/><hr/><hr/><hr/>
    </div>
    <div id="uploaded-data"></div>
    <div style="float: right; margin-bottom: 4px;">
        <?= Html::a('Delete all', ['delete-all', 'type' => Yii::$app->controller->action->id], [
            'class' => 'btn btn-warning',
            'data-method' => 'post',
            'data-confirm' => 'Are You sure?'
        ])?>
    </div>
    <?php Pjax::begin(['id' => 'pjax-container']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute' => 'id', 'contentOptions' => ['style' => 'width: 100px;'],],
            'value',
            ['attribute' => 'created_at', 'contentOptions' => ['style' => 'width: 170px;'],],
            [
                'class' => ActionColumn::class,
                'buttons' => [
                    'delete' => function ($url, $model) {
                        $url = Url::to(['delete', 'id' => $model->id, 'type' => Yii::$app->controller->action->id]);
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'data-method' => 'post',
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
