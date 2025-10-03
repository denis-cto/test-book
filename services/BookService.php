<?php

namespace app\services;

use app\models\Book;
use app\models\BookAuthor;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Сервис для работы с книгами
 */
class BookService
{
    /**
     * Создает новую книгу
     * @param array $data Данные книги
     * @param UploadedFile|null $coverFile Файл обложки
     * @return Book
     * @throws Exception
     */
    public function createBook(array $data, ?UploadedFile $coverFile = null): Book
    {
        $book = new Book();
        $book->load($data, '');

        if (!$book->save()) {
            throw new Exception('Не удалось сохранить книгу: ' . implode(', ', $book->getFirstErrors()));
        }

        // Авторы сохраняются автоматически в afterSave модели

        // Загружаем обложку
        if ($coverFile) {
            $book->coverFile = $coverFile;
            if (!$book->upload()) {
                throw new Exception('Не удалось загрузить обложку');
            }
            $book->save(false);
        }

        return $book;
    }

    /**
     * Сохраняет связи книги с авторами
     * @param Book $book
     * @param array $authorIds
     * @return void
     */
    private function saveAuthors(Book $book, array $authorIds): void
    {
        BookAuthor::deleteAll(['book_id' => $book->id]);

        foreach ($authorIds as $authorId) {
            $bookAuthor = new BookAuthor();
            $bookAuthor->book_id = $book->id;
            $bookAuthor->author_id = $authorId;
            $bookAuthor->created_at = time();
            $bookAuthor->save();
        }
    }

    /**
     * Обновляет книгу
     * @param Book $book Книга для обновления
     * @param array $data Новые данные
     * @param UploadedFile|null $coverFile Новый файл обложки
     * @return Book
     * @throws Exception
     */
    public function updateBook(Book $book, array $data, ?UploadedFile $coverFile = null): Book
    {
        $book->load($data, '');
        
        // Устанавливаем authorIds для обновления связей
        if (isset($data['authorIds'])) {
            $book->authorIds = $data['authorIds'];
            \Yii::info('BookService - Setting authorIds: ' . json_encode($data['authorIds']), 'debug');
        } else {
            \Yii::info('BookService - No authorIds in data', 'debug');
        }

        if (!$book->save()) {
            throw new Exception('Не удалось обновить книгу: ' . implode(', ', $book->getFirstErrors()));
        }

        // Авторы обновляются автоматически в afterSave модели

        // Загружаем новую обложку
        if ($coverFile) {
            $book->coverFile = $coverFile;
            if (!$book->upload()) {
                throw new Exception('Не удалось загрузить обложку');
            }
            $book->save(false);
        }

        return $book;
    }

    /**
     * Удаляет книгу
     * @param Book $book Книга для удаления
     * @return bool
     */
    public function deleteBook(Book $book): bool
    {
        $book->deleteCover();
        return $book->delete() > 0;
    }
}
