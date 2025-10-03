<?php

use yii\helpers\Url;

class AuthorCest
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

    public function authorIndexPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that author index page works');
        $I->amOnPage(Url::toRoute('/author/index'));
        $I->see('Авторы', 'h1');
    }

    public function authorCreatePageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that author create page works');
        $I->amOnPage(Url::toRoute('/author/create'));
        $I->see('Создать автора', 'h1');
    }

    public function authorCanBeCreated(AcceptanceTester $I)
    {
        $I->wantTo('create a new author');

        // Переходим на страницу создания автора
        $I->amOnPage(Url::toRoute('/author/create'));

        // Заполняем форму
        $I->fillField('input[name="Author[first_name]"]', 'Александр');
        $I->fillField('input[name="Author[last_name]"]', 'Пушкин');
        $I->fillField('input[name="Author[middle_name]"]', 'Сергеевич');

        // Отправляем форму
        $I->click('button[type="submit"]');
        $I->wait(2);

        // Проверяем, что автор создан
        $I->see('Пушкин Александр Сергеевич');
    }

    public function authorViewPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('view an author');
        $I->amOnPage(Url::toRoute('/author/view?id=1'));
        $I->see('Пушкин Александр Сергеевич');
    }
}
