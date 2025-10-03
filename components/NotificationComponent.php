<?php

namespace app\components;

use app\models\Book;
use app\models\Subscription;
use Yii;
use yii\base\Component;
use yii\db\Exception;

class NotificationComponent extends Component
{
    private $smsService;

    public function init(): void
    {
        parent::init();
        $this->smsService = Yii::$app->sms;
    }

    /**
     * @throws Exception
     */
    public function notifyNewBook(Book $book): bool
    {
        Yii::info("Starting SMS notification for book ID: {$book->id}", 'sms');

        if (empty($book->authors)) {
            Yii::info("No authors found for book ID: {$book->id}", 'sms');
            return false;
        }

        $authorIds = $this->getAuthorIds($book);
        Yii::info("Author IDs for book {$book->id}: " . implode(', ', $authorIds), 'sms');

        $subscriptions = $this->getActiveSubscriptions($authorIds);
        Yii::info("Found subscriptions: " . count($subscriptions), 'sms');

        if (empty($subscriptions)) {
            Yii::info("No active subscriptions found for book ID: {$book->id}", 'sms');
            return false;
        }

        $message = $this->buildBookMessage($book);
        $totalSuccess = 0;
        $totalFailed = 0;

        // Создаем SMS кампанию для каждого автора
        foreach ($authorIds as $authorId) {
            $authorSubscriptions = array_filter($subscriptions, function ($sub) use ($authorId) {
                return $sub->author_id == $authorId;
            });

            if (empty($authorSubscriptions)) {
                continue;
            }

            $authorPhones = $this->extractPhones($authorSubscriptions);
            if (empty($authorPhones)) {
                continue;
            }

            // Создаем кампанию
            $campaign = \app\models\SmsCampaign::createCampaign($book->id, $authorId, $message);
            $campaign->save(false);

            $authorSuccessCount = 0;
            $authorFailCount = 0;

            // Отправляем SMS для этого автора
            foreach ($authorPhones as $phone) {
                $result = $this->smsService->sendSms($phone, $message);
                if ($result) {
                    $authorSuccessCount++;
                    $totalSuccess++;
                } else {
                    $authorFailCount++;
                    $totalFailed++;
                }
            }

            // Обновляем статистику кампании
            $campaign->updateStats(count($authorPhones), $authorSuccessCount, $authorFailCount);
        }

        Yii::info("SMS notifications sent for book {$book->id}: {$totalSuccess} successful, {$totalFailed} failed", 'sms');

        return $totalSuccess > 0;
    }


    private function getAuthorIds(Book $book): array
    {
        $authorIds = [];
        foreach ($book->authors as $author) {
            $authorIds[] = $author->id;
        }
        return $authorIds;
    }

    private function getActiveSubscriptions(array $authorIds): array
    {
        return Subscription::find()
            ->where(['author_id' => $authorIds, 'is_active' => true])
            ->andWhere(['not', ['phone' => null]])
            ->all();
    }

    private function buildBookMessage(Book $book): string
    {
        $authorsNames = [];
        foreach ($book->authors as $author) {
            $authorsNames[] = $author->getFullName();
        }

        return "Новая книга: \"{$book->title}\" от " . implode(', ', $authorsNames) . " ({$book->year})";
    }

    private function extractPhones(array $subscriptions): array
    {
        $phones = [];
        foreach ($subscriptions as $subscription) {
            if (!empty($subscription->phone)) {
                $phones[] = $subscription->phone;
            }
        }
        return $phones;
    }
}
