<?php

namespace app\controllers;

use app\exceptions\ValidationException;
use app\models\Book;
use app\models\BookSearch;
use app\services\BookService;
use app\traits\FileUploadTrait;
use Yii;
use yii\web\NotFoundHttpException;

class BookController extends BaseController
{
    use FileUploadTrait;

    public function actionIndex(): string
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        $model = Book::findWithAuthors($id);
        if (!$model) {
            throw new NotFoundHttpException('Книга не найдена.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): string|\yii\web\Response
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validate()) {
                throw new ValidationException($model->getFirstErrors());
            }

            try {
                $coverFile = $this->getUploadedCoverFile($model);
                $bookService = new BookService();

                $bookData = $model->attributes;
                $bookData['authorIds'] = $model->authorIds;
                $book = $bookService->createBook($bookData, $coverFile);

                $book->refresh();
                $book->authors;

                Yii::$app->notification->notifyNewBook($book);
                Yii::$app->session->setFlash('success', 'Книга успешно создана');
                return $this->redirect(['view', 'id' => $book->id]);

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
        $model = $this->findModel($id, Book::class);

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validate()) {
                throw new ValidationException($model->getFirstErrors());
            }

            try {
                $coverFile = $this->getUploadedCoverFile($model);
                $bookService = new BookService();

                $bookData = $model->attributes;
                $bookData['authorIds'] = $model->authorIds;
                
                // Убеждаемся, что authorIds передается правильно
                Yii::info('Controller - authorIds: ' . json_encode($model->authorIds), 'debug');
                
                $book = $bookService->updateBook($model, $bookData, $coverFile);

                Yii::$app->session->setFlash('success', 'Книга успешно обновлена');
                return $this->redirect(['view', 'id' => $book->id]);

            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id): \yii\web\Response
    {

        try {
            $model = $this->findModel($id, Book::class);

            $bookService = new BookService();
            $bookService->deleteBook($model);
            Yii::$app->session->setFlash('success', 'Книга успешно удалена');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteCover($id): \yii\web\Response
    {
        $model = $this->findModel($id, Book::class);
        $model->deleteCover();
        $model->save(false);

        Yii::$app->session->setFlash('success', 'Обложка удалена.');
        return $this->redirect(['update', 'id' => $model->id]);
    }

}
