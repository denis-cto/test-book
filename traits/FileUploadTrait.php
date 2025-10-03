<?php

namespace app\traits;

use yii\web\UploadedFile;

/**
 * Трейт для работы с загрузкой файлов
 */
trait FileUploadTrait
{
    /**
     * Получает загруженный файл обложки
     * @param object $model Модель с полем coverFile
     * @return UploadedFile|null
     */
    protected function getUploadedCoverFile($model): ?UploadedFile
    {
        return UploadedFile::getInstance($model, 'coverFile');
    }

}
