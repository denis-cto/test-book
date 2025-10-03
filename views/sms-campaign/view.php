<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'SMS Рассылка #' . $model->id;
?>
<div class="sms-campaign-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                    'id',
                    [
                            'attribute' => 'book_id',
                            'label' => 'Книга',
                            'value' => function ($model) {
                                return $model->book ? Html::a($model->book->title, ['/book/view', 'id' => $model->book->id]) : 'Не найдена';
                            },
                            'format' => 'raw',
                    ],
                    [
                            'attribute' => 'author_id',
                            'label' => 'Автор',
                            'value' => function ($model) {
                                return $model->author ? Html::a($model->author->getFullName(), ['/author/view', 'id' => $model->author->id]) : 'Не найден';
                            },
                            'format' => 'raw',
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
                            'attribute' => 'message',
                            'label' => 'Сообщение',
                            'format' => 'ntext',
                    ],
                    [
                            'attribute' => 'created_at',
                            'label' => 'Дата создания',
                            'value' => function ($model) {
                                return date('d.m.Y H:i:s', $model->created_at);
                            },
                    ],
                    [
                            'attribute' => 'updated_at',
                            'label' => 'Дата обновления',
                            'value' => function ($model) {
                                return date('d.m.Y H:i:s', $model->updated_at);
                            },
                    ],
            ],
    ]) ?>

</div>
