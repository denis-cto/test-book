<?php

namespace app\controllers;

use Yii;
use yii\db\ActiveRecord;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

abstract class BaseController extends Controller
{
    public function behaviors(): array
    {
        return $this->getBehaviors();
    }

    public function getBehaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'report', 'login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'update', 'delete', 'delete-cover'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    protected function findModel(int $id, string $modelClass): ActiveRecord
    {
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Страница не найдена.');
    }

    protected function handleModelSave(ActiveRecord $model, string $viewName): string|\yii\web\Response
    {
        if ($model->load(Yii::$app->request->post())) {
            try {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render($viewName, [
            'model' => $model,
        ]);
    }

}
