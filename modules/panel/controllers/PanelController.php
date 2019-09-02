<?php

namespace app\modules\panel\controllers;

use app\modules\panel\models\form\UploadForm;
use app\modules\panel\models\search\TokenSearch;
use app\modules\panel\models\TokenAccepted;
use app\modules\panel\models\TokenActive;
use app\modules\panel\models\TokenCanceled;
use SplFileObject;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Panel controller for the `panel` module
 */
class PanelController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['active', 'accepted', 'canceled', 'file-upload', 'file-validate', 'delete', 'delete-all'],
                'rules' => [
                    [
                        'actions' => ['active', 'accepted', 'canceled', 'file-upload', 'file-validate', 'delete', 'delete-all'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['active', 'accepted', 'canceled', 'file-upload', 'file-validate', 'delete'],
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function($rule, $action) {
                            return $action->controller->redirect('/site/login');
                        },
                    ]
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
//                    'delete-all' => ['POST'],
                ],
            ],
        ];
    }




    public function actionActive()
    {
        $model = new UploadForm();
        $searchModel = new TokenSearch();
        $dataProvider = $searchModel->searchActive(Yii::$app->request->queryParams);

        return $this->render('grid-view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'withFileInput' => true,
            'model' => $model
        ]);
    }

    public function actionCanceled()
    {
        $searchModel = new TokenSearch();
        $dataProvider = $searchModel->searchCanceled(Yii::$app->request->queryParams);

        return $this->render('grid-view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'withFileInput' => false
        ]);
    }

    public function actionAccepted()
    {
        $searchModel = new TokenSearch();
        $dataProvider = $searchModel->searchAccepted(Yii::$app->request->queryParams);

        return $this->render('grid-view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'withFileInput' => false
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws MethodNotAllowedHttpException
     */
    public function actionFileUpload()
    {
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {
                $model->saveTokens();
                return $this->asJson([
                    'status' => 'success',
                    'html' => $this->renderAjax('_uploaded_items', ['model' => $model])
                ]);
            }
        }

        throw new MethodNotAllowedHttpException();
    }

    public function actionFileValidate()
    {
        $model = new UploadForm();
        $request = \Yii::$app->getRequest();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        return $this->asJson(['validate' => true]);
    }

    public function actionDelete($id, $type)
    {
        $types = [
            'active' => TokenActive::find(),
            'canceled' => TokenCanceled::find(),
            'accepted' => TokenAccepted::find(),
        ];
        $model = $types[$type]->where(['id' => $id])->one();
        $model->delete();

        return $this->redirect([
            "/panel/panel/{$type}"
        ]);
    }

    public function actionDeleteAll($type)
    {
        if ($type == 'active') {
            TokenActive::deleteAll();
        } elseif ($type == 'canceled') {
            TokenCanceled::deleteAll();
        } elseif ($type == 'accepted') {
            TokenAccepted::deleteAll();
        }

        return $this->redirect([
            "/panel/panel/{$type}"
        ]);
    }
}
