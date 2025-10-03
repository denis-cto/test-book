<?php

use yii\helpers\Html;

$this->title = $model->getFullName();
?>
<div class="author-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этого автора?',
                            'method' => 'post',
                    ],
            ]) ?>
        </p>
    <?php endif; ?>

    <?= \yii\widgets\DetailView::widget([
            'model' => $model,
            'attributes' => [
                    'first_name',
                    'last_name',
                    'middle_name',
                    'created_at:datetime',
            ],
    ]) ?>

    <h3>Книги</h3>
    <ul>
        <?php foreach ($model->books as $book): ?>
            <li>
                <?= Html::a(Html::encode($book->title), ['/book/view', 'id' => $book->id]) ?>
                (<?= Html::encode($book->year) ?>)
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (Yii::$app->user->isGuest): ?>
        <h3>Подписаться на новые книги</h3>
        <?php $form = \yii\widgets\ActiveForm::begin(['action' => ['/subscription/subscribe']]); ?>
        <?= Html::hiddenInput('author_id', $model->id) ?>
        <div class="form-group">
            <label>Телефон:</label>
            <?= Html::textInput('phone', '', ['class' => 'form-control', 'required' => true]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Подписаться', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php \yii\widgets\ActiveForm::end(); ?>
    <?php endif; ?>

</div>
