<?php

namespace app\controllers;

use Yii;

class ReportController extends BaseController
{
    public function getBehaviors(): array
    {
        $behaviors = parent::getBehaviors();

        // Переопределяем правила доступа для отчета
        $behaviors['access']['rules'] = [
            [
                'actions' => ['top-authors'],
                'allow' => true,
            ],
        ];

        return $behaviors;
    }

    public function actionTopAuthors(): string
    {
        $requestedYear = Yii::$app->request->get('year');
        $year = $requestedYear ? (int)$requestedYear : (int)date('Y');

        $reportService = Yii::$app->reportService;
        $authorsData = $reportService->getTopAuthorsByYear($year);

        return $this->render('top-authors', [
            'authors' => $authorsData,
            'year' => $year,
        ]);
    }
}