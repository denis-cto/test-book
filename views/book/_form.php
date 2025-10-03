<?php

use app\models\Author;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coverFile')->fileInput() ?>

    <?php if ($model->cover_image): ?>
        <div class="current-cover">
            <p>Текущая обложка:</p>
            <img src="<?= $model->getThumbnailUrl() ?>" alt="Обложка" style="max-width: 100px; max-height: 100px;">
            <p><?= Html::a('Удалить обложку', ['delete-cover', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить обложку?',
                                'method' => 'post',
                        ],
                ]) ?></p>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'authorIds')->checkboxList(
            ArrayHelper::map(Author::find()->all(), 'id', 'fullName'),
            ['multiple' => true]
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
