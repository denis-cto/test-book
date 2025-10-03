<?php

use yii\helpers\Html;

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #333;
            color: white;
            padding: 10px;
        }

        .header a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
        }

        .header a:hover {
            text-decoration: underline;
        }

        .content {
            padding: 20px;
        }

        .alert {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid;
        }

        .alert-success {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-info {
            background: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .btn {
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid;
            display: inline-block;
            margin: 2px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .btn-success {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .btn-warning {
            background: #ffc107;
            color: black;
            border-color: #ffc107;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .form-group {
            margin: 10px 0;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .card {
            border: 1px solid #ddd;
            margin: 10px 0;
        }

        .card-header {
            background: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-6 {
            flex: 0 0 50%;
            padding: 0 10px;
        }

        .col-md-4 {
            flex: 0 0 33.333%;
            padding: 0 10px;
        }

        .col-md-8 {
            flex: 0 0 66.666%;
            padding: 0 10px;
        }

        .col-12 {
            flex: 0 0 100%;
            padding: 0 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #6c757d;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        .mt-4 {
            margin-top: 20px;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="header">
    <a href="<?= \yii\helpers\Url::to(['/site/index']) ?>">Каталог книг</a>
    <a href="<?= \yii\helpers\Url::to(['/book/index']) ?>">Книги</a>
    <a href="<?= \yii\helpers\Url::to(['/author/index']) ?>">Авторы</a>
    <a href="<?= \yii\helpers\Url::to(['/report/top-authors']) ?>">Отчет</a>
    <?php if (!Yii::$app->user->isGuest): ?>
        <a href="<?= \yii\helpers\Url::to(['/sms-campaign/index']) ?>">SMS Рассылки</a>
    <?php endif; ?>
    <div style="float: right;">
        <?php if (Yii::$app->user->isGuest): ?>
            <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>">Вход</a>
        <?php else: ?>
            <span>Привет, <?= Yii::$app->user->identity->username ?>!</span>
            <?= Html::beginForm(['/site/logout'], 'post', ['style' => 'display: inline; margin-left: 10px;']) ?>
            <?= Html::submitButton('Выход', ['style' => 'background: none; border: none; color: white; cursor: pointer;']) ?>
            <?= Html::endForm() ?>
        <?php endif; ?>
    </div>
</div>

<div class="content">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('info')): ?>
        <div class="alert alert-info">
            <?= Yii::$app->session->getFlash('info') ?>
        </div>
    <?php endif; ?>

    <?= $content ?>
</div>

<div class="footer">
    <p>&copy; Каталог книг <?= date('Y') ?> | Powered by <?= Yii::powered() ?></p>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
