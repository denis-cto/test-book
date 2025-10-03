<?php

namespace app\controllers;

use app\models\Author;
use app\models\Subscription;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SubscriptionController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'subscribe' => ['POST'],
                ],
            ],
        ];
    }

    public function actionSubscribe(): string|\yii\web\Response
    {
        $authorId = Yii::$app->request->post('author_id');
        $phone = Yii::$app->request->post('phone');

        if (!$authorId || !$phone) {
            Yii::$app->session->setFlash('error', 'Необходимо указать автора и номер телефона.');
            return $this->redirect(Yii::$app->request->referrer);
        }

        try {
            $author = Author::findOne($authorId);
            if (!$author) {
                Yii::$app->session->setFlash('error', 'Автор не найден.');
                return $this->redirect(Yii::$app->request->referrer);
            }

            $existingSubscription = Subscription::find()
                ->where(['author_id' => $authorId, 'phone' => $phone])
                ->one();

            if ($existingSubscription) {
                if ($existingSubscription->is_active) {
                    Yii::$app->session->setFlash('info', 'Вы уже подписаны на этого автора.');
                } else {
                    $existingSubscription->is_active = true;
                    if ($existingSubscription->save()) {
                        Yii::$app->session->setFlash('success', 'Подписка активирована.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка при активации подписки.');
                    }
                }
            } else {
                $subscription = new Subscription();
                $subscription->author_id = $authorId;
                $subscription->phone = $phone;
                $subscription->is_active = true;

                if ($subscription->save()) {
                    Yii::$app->session->setFlash('success', 'Подписка успешно оформлена.');
                } else {
                    $errors = $subscription->getFirstErrors();
                    $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Ошибка при оформлении подписки.';
                    Yii::$app->session->setFlash('error', $errorMessage);
                }
            }
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

}
