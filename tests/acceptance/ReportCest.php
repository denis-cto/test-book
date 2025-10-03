<?php

use yii\helpers\Url;

class ReportCest
{
    public function reportTopAuthorsPageWorks(AcceptanceTester $I)
    {
        $I->wantTo('ensure that report page works');
        $I->amOnPage(Url::toRoute('/report/top-authors'));
        $I->see('ТОП 10 авторов', 'h1');
    }

    public function reportCanFilterByYear(AcceptanceTester $I)
    {
        $I->wantTo('filter report by year');

        // Переходим на страницу отчета
        $I->amOnPage(Url::toRoute('/report/top-authors'));

        // Меняем год
        $I->fillField('input[name="year"]', '2024');
        $I->click('button[type="submit"]');
        $I->wait(2);

        // Проверяем, что год изменился
        $I->see('ТОП 10 авторов за 2024 год');
    }
}
