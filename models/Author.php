<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Author extends ActiveRecord
{
    public static function tableName()
    {
        return static::getTableName();
    }

    public static function getTableName(): string
    {
        return '{{%authors}}';
    }

    public static function getPopularAuthors(int $limit = 5): array
    {
        return static::find()
            ->select(['authors.*', 'COUNT(books.id) as books_count'])
            ->joinWith('books')
            ->groupBy('authors.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function getTopAuthorsByYear(int $year, int $limit = 10): \yii\db\ActiveQuery
    {
        return static::find()
            ->select(['authors.*', 'COUNT(books.id) as books_count'])
            ->joinWith('books')
            ->where(['books.year' => $year])
            ->groupBy('authors.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit($limit);
    }

    public static function findWithBooks(int $id): ?self
    {
        return static::find()
            ->where(['id' => $id])
            ->with('books')
            ->one();
    }

    public function behaviors(): array
    {
        return $this->getBehaviors();
    }

    public function getBehaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return $this->getValidationRules();
    }

    public function getValidationRules(): array
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name', 'middle_name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels(): array
    {
        return $this->getAttributeLabels();
    }

    public function getAttributeLabels(): array
    {
        return [
            'id' => 'ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getBookAuthors(): \yii\db\ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['author_id' => 'id']);
    }


    public function getFullName(): string
    {
        $name = $this->last_name . ' ' . $this->first_name;
        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }
        return $name;
    }


    public function getBooks(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Book::class, ['id' => 'book_id'])->viaTable('{{%book_authors}}', ['author_id' => 'id']);
    }

    public function getBooksCount(): int
    {
        if ($this->isRelationPopulated('books')) {
            return count($this->books);
        }
        return $this->getBooks()->count();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }


}
