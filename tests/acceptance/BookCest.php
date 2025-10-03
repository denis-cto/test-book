<?php

use yii\helpers\Url;

class BookCest
{
    public function _before(\AcceptanceTester $I)
    {
        // Авторизуемся как admin
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');
        $I->wait(2);
    }

    public function bookIndexPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that book index page works');
        $I->amOnPage(Url::toRoute('/book/index'));
        $I->see('Книги', 'h1');
    }

    public function bookCreatePageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that book create page works');
        $I->amOnPage(Url::toRoute('/book/create'));
        $I->see('Создать книгу', 'h1');
    }

    public function bookCanBeCreated(AcceptanceTester $I)
    {
        $I->wantTo('create a new book');

        // Переходим на страницу создания книги
        $I->amOnPage(Url::toRoute('/book/create'));

        // Заполняем форму
        $I->fillField('input[name="Book[title]"]', 'Тестовая книга');
        $I->fillField('input[name="Book[year]"]', '2025');
        $I->fillField('textarea[name="Book[description]"]', 'Описание тестовой книги');
        $I->fillField('input[name="Book[isbn]"]', '978-5-699-12345-6');

        // Выбираем автора (если есть)
        $I->checkOption('input[name="Book[authorIds][]"][value="1"]');

        // Отправляем форму
        $I->click('button[type="submit"]');
        $I->wait(2);

        // Проверяем, что книга создана
        $I->see('Тестовая книга');
        $I->see('2025');
    }

    public function bookViewPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('view a book');
        $I->amOnPage(Url::toRoute('/book/view?id=1'));
        $I->see('Тестовая книга');
    }
}
