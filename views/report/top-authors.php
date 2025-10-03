<?php

use yii\helpers\Html;

$this->title = 'ТОП 10 авторов за ' . $year . ' год';
?>

<div class="report-top-authors">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Авторы, выпустившие больше всего книг в <?= $year ?> году</h3>
                </div>
                <div class="panel-body">
                    <?php if (empty($authors)): ?>
                        <p class="text-muted">За выбранный год книги не найдены.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Место</th>
                                    <th>Автор</th>
                                    <th>Количество книг</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($authors as $index => $author): ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary"><?= $index + 1 ?></span>
                                        </td>
                                        <td>
                                            <?= Html::encode(trim($author['first_name'] . ' ' . $author['last_name'] . ' ' . $author['middle_name'])) ?>
                                        </td>
                                        <td>
                                            <span class="label label-info"><?= $author['books_count'] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="year-select">Выберите год:</label>
                <select id="year-select" class="form-control" style="width: auto; display: inline-block;">
                    <?php for ($i = 2025; $i >= 2020; $i--): ?>
                        <option value="<?= $i ?>" <?= $i == $year ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
                <button type="button" class="btn btn-primary" onclick="changeYear()">Показать</button>
            </div>
        </div>
    </div>
</div>

<script>
    function changeYear() {
        var year = document.getElementById('year-select').value;
        window.location.href = '<?= \yii\helpers\Url::to(['report/top-authors']) ?>?year=' + year;
    }
</script>