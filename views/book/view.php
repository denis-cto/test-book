<?php

use yii\helpers\Html;

$this->title = $model->title;
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                            'method' => 'post',
                    ],
            ]) ?>
        </p>
    <?php endif; ?>

    <?php if ($model->getCoverUrl()): ?>
        <div class="book-cover">
            <h3>Обложка</h3>
            <?= Html::a(
                    Html::img($model->getCoverUrl(), ['style' => 'max-width: 300px; max-height: 400px; object-fit: contain;']),
                    $model->getCoverUrl(),
                    ['target' => '_blank', 'title' => 'Открыть полное изображение']
            ) ?>
            <?php if (!Yii::$app->user->isGuest): ?>
                <p style="margin-top: 10px;">
                    <?= Html::a('Удалить обложку', ['delete-cover', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить обложку?',
                                    'method' => 'post',
                            ],
                    ]) ?>
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?= \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                    'title',
                    'year',
                    'isbn',
                    'description:ntext',
                    'created_at:datetime',
            ],
    ]) ?>

    <h3>Авторы</h3>
    <ul>
        <?php if ($model->authors): ?>
            <?php foreach ($model->authors as $author): ?>
                <li>
                    <?= Html::a(Html::encode($author->getFullName()), ['/author/view', 'id' => $author->id]) ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Авторы не указаны</li>
        <?php endif; ?>
    </ul>

</div>
