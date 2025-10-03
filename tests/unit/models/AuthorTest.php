<?php

namespace tests\unit\models;

use app\models\Author;
use app\models\Book;

class AuthorTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testAuthorCreation()
    {
        $author = new Author();
        $author->first_name = 'Александр';
        $author->last_name = 'Пушкин';
        $author->middle_name = 'Сергеевич';

        $this->assertTrue($author->save());
        $this->assertNotNull($author->id);
    }

    public function testAuthorValidation()
    {
        $author = new Author();

        // Тест без обязательных полей
        $this->assertFalse($author->save());
        $this->assertArrayHasKey('first_name', $author->errors);
        $this->assertArrayHasKey('last_name', $author->errors);

        // Тест с корректными данными
        $author->first_name = 'Лев';
        $author->last_name = 'Толстой';
        $this->assertTrue($author->save());
    }

    public function testGetFullName()
    {
        $author = new Author();
        $author->first_name = 'Федор';
        $author->last_name = 'Достоевский';
        $author->middle_name = 'Михайлович';

        $fullName = $author->getFullName();
        $this->assertEquals('Достоевский Федор Михайлович', $fullName);

        // Тест без отчества
        $author->middle_name = null;
        $fullName = $author->getFullName();
        $this->assertEquals('Достоевский Федор', $fullName);
    }


}
