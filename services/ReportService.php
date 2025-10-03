<?php

namespace app\services;

use Yii;
use yii\db\Query;

/**
 * Сервис для работы с отчетами
 */
class ReportService
{
    /**
     * Получает топ авторов за указанный год
     * @param int $year Год для отчета
     * @param int $limit Лимит записей (по умолчанию 10)
     * @return array
     */
    public function getTopAuthorsByYear(int $year, int $limit = 10): array
    {
        $query = (new Query())
            ->select([
                'a.id',
                'a.first_name',
                'a.last_name', 
                'a.middle_name',
                'a.created_at',
                'a.updated_at',
                'COUNT(b.id) as books_count'
            ])
            ->from(['a' => 'authors'])
            ->innerJoin(['ba' => 'book_authors'], 'a.id = ba.author_id')
            ->innerJoin(['b' => 'books'], 'ba.book_id = b.id')
            ->where(['b.year' => $year])
            ->groupBy('a.id')
            ->orderBy(['books_count' => SORT_DESC])
            ->limit($limit);

        return $query->all(Yii::$app->db);
    }

}
