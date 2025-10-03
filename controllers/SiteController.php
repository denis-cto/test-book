<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use yii\web\Response;

class SiteController extends BaseController
{
    public function getBehaviors(): array
    {
        $behaviors = parent::getBehaviors();

        // Добавляем специфичные правила для SiteController
        $behaviors['access']['rules'][] = [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
        ];

        $behaviors['verbs']['actions']['logout'] = ['post'];

        return $behaviors;
    }

    public function actions(): array
    {
        return $this->getActions();
    }

    public function getActions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render('index', [
            'recentBooks' => \app\models\Book::getRecentBooks(),
            'popularAuthors' => \app\models\Author::getPopularAuthors(),
        ]);
    }

    public function actionLogin(): string|\yii\web\Response
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

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}
