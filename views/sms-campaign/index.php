<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'SMS Рассылки';
?>
<div class="sms-campaign-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                            'attribute' => 'book_id',
                            'label' => 'Книга',
                            'value' => function ($model) {
                                return $model->book ? $model->book->title : 'Не найдена';
                            },
                    ],
                    [
                            'attribute' => 'author_id',
                            'label' => 'Автор',
                            'value' => function ($model) {
                                return $model->author ? $model->author->getFullName() : 'Не найден';
                            },
                    ],
                    'total_recipients',
                    'sent_successfully',
                    'sent_failed',
                    [
                            'label' => 'Успешность',
                            'value' => function ($model) {
                                return $model->getSuccessRate() . '%';
                            },
                    ],
                    [
                            'attribute' => 'created_at',
                            'label' => 'Дата рассылки',
                            'value' => function ($model) {
                                return date('d.m.Y H:i', $model->created_at);
                            },
                    ],

                    [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view}',
                    ],
            ],
    ]); ?>

</div>
