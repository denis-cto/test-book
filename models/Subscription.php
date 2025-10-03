<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Subscription extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%subscriptions}}';
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
            [['author_id'], 'required'],
            [['author_id'], 'integer'],
            [['phone'], 'string'],
            [['phone'], 'string', 'max' => 20],
            [['is_active'], 'boolean'],
            [['phone', 'author_id'], 'unique', 'targetAttribute' => ['phone', 'author_id'], 'message' => 'Вы уже подписаны на этого автора с данным номером телефона.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'phone' => 'Телефон',
            'is_active' => 'Активна',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getAuthor(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }
}
