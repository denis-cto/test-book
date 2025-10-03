<?php

namespace tests\unit\models;

use app\models\Author;
use app\models\Book;
use app\models\BookAuthor;

class BookTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;




    public function testGetAuthorsNames()
    {
        // Создаем авторов
        $author1 = new Author();
        $author1->first_name = 'Иван';
        $author1->last_name = 'Иванов';
        $author1->save();

        $author2 = new Author();
        $author2->first_name = 'Петр';
        $author2->last_name = 'Петров';
        $author2->save();

        // Создаем книгу
        $book = new Book();
        $book->title = 'Тестовая книга';
        $book->year = 2025;
        $book->authorIds = [$author1->id, $author2->id];
        $book->save();
        $book->saveAuthors();

        // Проверяем имена авторов
        $authorsNames = $book->getAuthorsNames();
        $this->assertStringContainsString('Иванов Иван', $authorsNames);
        $this->assertStringContainsString('Петров Петр', $authorsNames);
    }

}
