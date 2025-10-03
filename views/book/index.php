<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Книги';
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Добавить книгу', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                            'attribute' => 'cover',
                            'label' => 'Обложка',
                            'format' => 'raw',
                            'value' => function ($model) {
                                if ($model->getThumbnailUrl()) {
                                    return Html::a(
                                            Html::img($model->getThumbnailUrl(), ['style' => 'width: 50px; height: 50px; object-fit: cover;']),
                                            $model->getCoverUrl(),
                                            ['target' => '_blank', 'title' => 'Открыть полное изображение']
                                    );
                                }
                                return 'Нет обложки';
                            },
                    ],
                    [
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                            },
                    ],
                    'year',
                    'isbn',
                    [
                            'attribute' => 'authors',
                            'label' => 'Авторы',
                            'value' => function ($model) {
                                return Html::encode($model->getAuthorsNames());
                            },
                    ],
                    [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {update} {delete}',
                            'visibleButtons' => [
                                    'update' => !Yii::$app->user->isGuest,
                                    'delete' => !Yii::$app->user->isGuest,
                            ],
                            'buttons' => [
                                    'view' => function ($url, $model) {
                                        return Html::a('Просмотр', $url, ['class' => 'btn btn-primary']);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('Редактировать', $url, ['class' => 'btn btn-warning']);
                                    },
                                    'delete' => function ($url, $model) {
                                        return Html::a('Удалить', $url, [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                        'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                                                ],
                                        ]);
                                    },
                            ],
                    ],
            ],
    ]); ?>

</div>
