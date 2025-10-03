<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Авторы';
?>
<div class="author-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                            'attribute' => 'full_name',
                            'label' => 'ФИО',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a($model->getFullName(), ['view', 'id' => $model->id]);
                            },
                    ],
                    [
                            'label' => 'Книг',
                            'value' => function ($model) {
                                return $model->getBooks()->count();
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
                                                        'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                                                        'method' => 'post',
                                                ],
                                        ]);
                                    },
                            ],
                    ],
            ],
    ]); ?>

</div>
