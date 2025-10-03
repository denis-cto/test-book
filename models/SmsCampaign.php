<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sms_campaigns".
 *
 * @property int $id
 * @property int $book_id
 * @property int $author_id
 * @property int $total_recipients
 * @property int $sent_successfully
 * @property int $sent_failed
 * @property string|null $message
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Book $book
 * @property Author $author
 */
class SmsCampaign extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sms_campaigns}}';
    }

    public static function createCampaign($bookId, $authorId, $message)
    {
        $campaign = new static();
        $campaign->book_id = $bookId;
        $campaign->author_id = $authorId;
        $campaign->message = $message;
        $campaign->total_recipients = 0;
        $campaign->sent_successfully = 0;
        $campaign->sent_failed = 0;
        return $campaign;
    }

    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id', 'total_recipients', 'sent_successfully', 'sent_failed'], 'integer'],
            [['message'], 'string'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'book_id' => 'Книга',
            'author_id' => 'Автор',
            'total_recipients' => 'Всего получателей',
            'sent_successfully' => 'Успешно отправлено',
            'sent_failed' => 'Неудачно отправлено',
            'message' => 'Сообщение',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getBook(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

    public function getAuthor(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Обновляет статистику кампании
     * @param int $total
     * @param int $successful
     * @param int $failed
     */
    public function updateStats($total, $successful, $failed)
    {
        $this->total_recipients = $total;
        $this->sent_successfully = $successful;
        $this->sent_failed = $failed;
        $this->save(false);
    }

    /**
     * Получает процент успешности
     * @return float
     */
    public function getSuccessRate(): float
    {
        if ($this->total_recipients == 0) {
            return 0;
        }
        return round(($this->sent_successfully / $this->total_recipients) * 100, 2);
    }
}
