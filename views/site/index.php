<?php

use yii\helpers\Html;

$this->title = 'Каталог книг';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Добро пожаловать в каталог книг! Здесь вы можете найти информацию о книгах и их авторах.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Последние книги</h5>
                </div>
                <div class="card-body">
                    <?php if ($recentBooks): ?>
                        <ul>
                            <?php foreach ($recentBooks as $book): ?>
                                <li style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <?php if ($book->getThumbnailUrl()): ?>
                                        <div style="margin-right: 10px;">
                                            <?= Html::a(
                                                    Html::img($book->getThumbnailUrl(), ['style' => 'width: 40px; height: 40px; object-fit: cover;']),
                                                    $book->getCoverUrl(),
                                                    ['target' => '_blank', 'title' => 'Открыть полное изображение']
                                            ) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <?= Html::a(Html::encode($book->title), ['/book/view', 'id' => $book->id]) ?>
                                        (<?= Html::encode($book->year) ?>)
                                        - <?= Html::encode($book->getAuthorsNames()) ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p><?= Html::a('Все книги', ['/book/index'], ['class' => 'btn btn-primary']) ?></p>
                    <?php else: ?>
                        <p>Книги пока не добавлены</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Популярные авторы</h5>
                </div>
                <div class="card-body">
                    <?php if ($popularAuthors): ?>
                        <ul>
                            <?php foreach ($popularAuthors as $author): ?>
                                <li>
                                    <?= Html::a(Html::encode($author->getFullName()), ['/author/view', 'id' => $author->id]) ?>
                                    (<?= Html::encode(isset($author->books_count) ? $author->books_count : $author->getBooksCount()) ?>
                                    книг)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p><?= Html::a('Все авторы', ['/author/index'], ['class' => 'btn btn-success']) ?></p>
                    <?php else: ?>
                        <p>Авторы пока не добавлены</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>О каталоге</h5>
                </div>
                <div class="card-body">
                    <p>В нашем каталоге вы можете:</p>
                    <ul>
                        <li>Просматривать информацию о книгах и авторах</li>
                        <li>Подписываться на уведомления о новых книгах любимых авторов</li>
                        <li>Просматривать отчеты и статистику</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
