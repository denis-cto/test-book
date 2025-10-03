<?php

namespace app\services;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

class BookCoverService
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png'];
    private const ALLOWED_MIME_TYPES = ['image/jpeg', 'image/png', 'image/jpg'];
    private const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB
    private const THUMBNAIL_SIZE = 100;

    public function uploadCover(int $bookId, UploadedFile $coverFile): ?string
    {
        if (!$this->validateFile($coverFile)) {
            return null;
        }

        $uploadPath = $this->getUploadPath($bookId);
        $this->ensureDirectoryExists($uploadPath);

        $coverPath = $uploadPath . '/cover.' . $coverFile->extension;
        $thumbnailPath = $uploadPath . '/cover_thumbnail.' . $coverFile->extension;

        if ($coverFile->saveAs($coverPath)) {
            $this->createThumbnail($coverPath, $thumbnailPath);
            return '/uploads/books/' . $this->getSafeId($bookId) . '/cover.' . $coverFile->extension;
        }

        return null;
    }

    public function deleteCover(string $coverImagePath): bool
    {
        if (empty($coverImagePath)) {
            return true;
        }

        $coverPath = Yii::getAlias('@webroot') . $coverImagePath;
        $pathInfo = pathinfo($coverPath);
        $thumbnailPath = $pathInfo['dirname'] . '/cover_thumbnail.' . $pathInfo['extension'];

        $deleted = true;

        if (file_exists($coverPath)) {
            $deleted = $deleted && unlink($coverPath);
        }

        if (file_exists($thumbnailPath)) {
            $deleted = $deleted && unlink($thumbnailPath);
        }

        return $deleted;
    }

    public function getCoverUrl(string $coverImagePath): ?string
    {
        if (empty($coverImagePath)) {
            return null;
        }

        return Yii::getAlias('@web') . $coverImagePath;
    }

    public function getThumbnailUrl(?string $coverImagePath): ?string
    {
        if (empty($coverImagePath)) {
            return null;
        }

        $pathInfo = pathinfo($coverImagePath);
        $thumbnailPath = $pathInfo['dirname'] . '/cover_thumbnail.' . $pathInfo['extension'];
        
        return Yii::getAlias('@web') . $thumbnailPath;
    }

    public function validateFile(UploadedFile $file): bool
    {
        if (!$file || $file->size > self::MAX_FILE_SIZE) {
            return false;
        }

        if (!in_array(strtolower($file->extension), self::ALLOWED_EXTENSIONS)) {
            return false;
        }

        return $this->validateFileMimeType($file);
    }

    private function getUploadPath(int $bookId): string
    {
        return Yii::getAlias('@webroot/uploads/books/' . $this->getSafeId($bookId));
    }

    private function ensureDirectoryExists(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    private function createThumbnail(string $sourcePath, string $thumbnailPath): void
    {
        try {
            Image::thumbnail($sourcePath, self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE)
                ->save($thumbnailPath, ['quality' => 90]);
        } catch (\Exception $e) {
            Yii::error('Ошибка создания миниатюры: ' . $e->getMessage());
        }
    }

    private function validateFileMimeType(UploadedFile $file): bool
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file->tempName);
        finfo_close($finfo);

        return in_array($mimeType, self::ALLOWED_MIME_TYPES);
    }

    private function getSafeId(int $bookId): string
    {
        return md5($bookId . (Yii::$app->params['appSecret'] ?? 'default_secret'));
    }
}
