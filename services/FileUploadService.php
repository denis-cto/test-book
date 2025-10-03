<?php

namespace app\services;

use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;

/**
 * Сервис для загрузки файлов
 */
class FileUploadService
{
    private const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png'];
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/jpg'];


    /**
     * Валидирует файл
     * @param UploadedFile $file
     * @throws Exception
     */
    private function validateFile(UploadedFile $file): void
    {
        if ($file->size > self::MAX_FILE_SIZE) {
            throw new Exception('Файл слишком большой. Максимальный размер: ' . (self::MAX_FILE_SIZE / 1024 / 1024) . 'MB');
        }

        if (!in_array($file->extension, self::ALLOWED_EXTENSIONS)) {
            throw new Exception('Недопустимое расширение файла. Разрешены: ' . implode(', ', self::ALLOWED_EXTENSIONS));
        }

        if (!$this->validateMimeType($file)) {
            throw new Exception('Недопустимый тип файла');
        }
    }

    /**
     * Валидирует MIME тип файла
     * @param UploadedFile $file
     * @return bool
     */
    private function validateMimeType(UploadedFile $file): bool
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file->tempName);
        finfo_close($finfo);

        return in_array($mimeType, self::ALLOWED_MIME_TYPES);
    }

    /**
     * Создает миниатюру изображения
     * @param string $sourcePath
     * @param string $thumbnailPath
     * @return void
     */
    private function createThumbnail(string $sourcePath, string $thumbnailPath): void
    {
        try {
            \yii\imagine\Image::thumbnail($sourcePath, 100, 100)
                ->save($thumbnailPath, ['quality' => 90]);
        } catch (\Exception $e) {
            Yii::error('Ошибка создания миниатюры: ' . $e->getMessage());
        }
    }
}
