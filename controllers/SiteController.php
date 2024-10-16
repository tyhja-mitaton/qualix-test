<?php

namespace app\controllers;

use app\models\Generator;
use app\models\UploadForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'settings' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'app\models\GeneratorSettings',
                //'scenario' => 'site',	// Change if you want to re-use the model for multiple setting form.
                //'section' => 'site', // By default use modelClass formname value
                'viewName' => 'settings'	// The form we need to render
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $path = Yii::getAlias('@webroot') . Generator::PATH_GALLERY;
        $files = scandir($path);
        $uploadForm = new UploadForm();
        if (Yii::$app->request->isPost) {
            $uploadForm->imageFiles = UploadedFile::getInstances($uploadForm, 'imageFiles');
            $uploadForm->upload();
            $this->redirect(['index']);
        }
        if($files) {
            $files = array_filter($files, function ($file) {
                return !in_array($file, ['.', '..']);
            });
        } else {
            $files = [];
        }
        return $this->render('index', [
            'files' => $files,
            'generator' => new Generator(),
            'uploadForm' => $uploadForm,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
