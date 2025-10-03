<?php

use yii\helpers\Html;

$this->title = 'Добавить книгу';
?>
<div class="book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'model' => $model,
    ]) ?>

</div>
