<?php

namespace tests\unit\models;

use app\models\Author;
use app\models\Subscription;

class SubscriptionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testSubscriptionCreation()
    {
        // Создаем автора
        $author = new Author();
        $author->first_name = 'Тест';
        $author->last_name = 'Автор';
        $author->save();

        // Создаем подписку
        $subscription = new Subscription();
        $subscription->author_id = $author->id;
        $subscription->phone = '79123456789';
        $subscription->is_active = true;

        $this->assertTrue($subscription->save());
        $this->assertNotNull($subscription->id);
    }



    public function testSubscriptionRelations()
    {
        // Создаем автора
        $author = new Author();
        $author->first_name = 'Тест';
        $author->last_name = 'Автор';
        $author->save();

        // Создаем подписку
        $subscription = new Subscription();
        $subscription->author_id = $author->id;
        $subscription->phone = '79123456789';
        $subscription->is_active = true;
        $subscription->save();

        // Проверяем связь с автором
        $this->assertNotNull($subscription->author);
        $this->assertEquals($author->id, $subscription->author->id);
        $this->assertEquals('Автор Тест', $subscription->author->getFullName());
    }
}
