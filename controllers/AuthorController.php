<?php

namespace app\controllers;

use app\models\Author;
use app\models\AuthorSearch;
use Yii;
use yii\web\NotFoundHttpException;

class AuthorController extends BaseController
{
    public function actionIndex(): string
    {
        $searchModel = new AuthorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->with('books');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        $model = Author::findWithBooks($id);
        if (!$model) {
            throw new NotFoundHttpException('Автор не найден.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): string|\yii\web\Response
    {
        $model = new Author();

        if ($model->load(Yii::$app->request->post())) {
            try {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id): string|\yii\web\Response
    {
        return $this->handleModelSave($this->findModel($id, Author::class), 'update');
    }

    public function actionDelete($id): \yii\web\Response
    {
        try {
            $this->findModel($id, Author::class)->delete();
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
}
