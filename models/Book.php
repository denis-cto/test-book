<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\services\BookCoverService;

class Book extends ActiveRecord
{
    public $authorIds = [];
    public $coverFile;
    /**
     * @var mixed|null
     */
    public $authors;

    public static function tableName()
    {
        return static::getTableName();
    }

    public static function getTableName(): string
    {
        return '{{%books}}';
    }

    public static function getRecentBooks(int $limit = 5): array
    {
        return static::find()
            ->with('authors')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public static function findWithAuthors(int $id): ?self
    {
        $book = static::find()
            ->where(['id' => $id])
            ->one();
            
        if ($book) {
            // Принудительно загружаем авторов
            $book->authors = $book->getAuthors()->all();
            \Yii::info('Book findWithAuthors - Book ID: ' . $id . ', Authors count: ' . count($book->authors ?? []), 'debug');
            if ($book->authors) {
                foreach ($book->authors as $author) {
                    \Yii::info('Book findWithAuthors - Author: ' . $author->id . ' - ' . $author->getFullName(), 'debug');
                }
            } else {
                \Yii::info('Book findWithAuthors - No authors loaded', 'debug');
            }
        }
        
        return $book;
    }

    public function behaviors(): array
    {
        return $this->getBehaviors();
    }

    public function getBehaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function rules(): array
    {
        return $this->getValidationRules();
    }

    public function getValidationRules(): array
    {
        return [
            [['title', 'year'], 'required'],
            [['year'], 'integer', 'min' => 1000, 'max' => date('Y') + 1],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20, 'skipOnEmpty' => true],
            [['cover_image'], 'string', 'max' => 500],
            [['isbn'], 'unique', 'skipOnEmpty' => true],
            [['isbn'], 'validateIsbn'],
            [['coverFile'], 'file',
                'extensions' => 'jpg, jpeg, png',
                'mimeTypes' => 'image/jpeg, image/png, image/jpg',
                'maxSize' => 5 * 1024 * 1024,
                'skipOnEmpty' => true,
                'checkExtensionByMimeType' => true,
            ],
            [['authorIds'], 'safe'],
        ];
    }

    public function attributeLabels(): array
    {
        return $this->getAttributeLabels();
    }

    public function getAttributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'year' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'ISBN',
            'cover_image' => 'Обложка',
            'coverFile' => 'Файл обложки',
            'authorIds' => 'Авторы',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getBookAuthors(): \yii\db\ActiveQuery
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getAuthorsNames(): string
    {
        // Всегда загружаем авторов через getAuthors(), так как with('authors') не работает с via()
        $authors = $this->getAuthors()->all();

        if (empty($authors)) {
            return 'Авторы не указаны';
        }
        $names = [];
        foreach ($authors as $author) {
            $names[] = $author->getFullName();
        }
        return implode(', ', $names);
    }

    public function getAuthors(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->via('bookAuthors');
    }

    public function afterFind(): void
    {
        parent::afterFind();
        if (!$this->isRelationPopulated('authors')) {
            $this->authorIds = $this->getAuthors()->select('id')->column();
        } else {
            $this->authorIds = $this->authors ? array_map(function ($author) {
                return $author->id;
            }, $this->authors) : [];
        }
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            // Преобразуем пустые ISBN в NULL
            if (empty($this->isbn)) {
                $this->isbn = null;
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        
        \Yii::info('Book afterSave - authorIds: ' . json_encode($this->authorIds), 'debug');
        
        if (!empty($this->authorIds)) {
            $this->saveAuthors();
        } else {
            \Yii::info('Book afterSave - authorIds is empty, skipping saveAuthors', 'debug');
        }
    }

    public function saveAuthors(): void
    {
        \Yii::info('Book saveAuthors - Deleting existing authors for book ID: ' . $this->id, 'debug');
        BookAuthor::deleteAll(['book_id' => $this->id]);

        if (!empty($this->authorIds)) {
            \Yii::info('Book saveAuthors - Saving authors: ' . json_encode($this->authorIds), 'debug');
            foreach ($this->authorIds as $authorId) {
                $bookAuthor = new BookAuthor();
                $bookAuthor->book_id = $this->id;
                $bookAuthor->author_id = $authorId;
                $bookAuthor->created_at = time();
                if ($bookAuthor->save()) {
                    \Yii::info('Book saveAuthors - Saved author ID: ' . $authorId, 'debug');
                } else {
                    \Yii::info('Book saveAuthors - Failed to save author ID: ' . $authorId . ', errors: ' . json_encode($bookAuthor->errors), 'debug');
                }
            }
        } else {
            \Yii::info('Book saveAuthors - No authors to save', 'debug');
        }
    }

    public function validateIsbn(string $attribute, ?array $params = null): void
    {
        if (empty($this->$attribute)) {
            return;
        }

        $originalIsbn = (string)$this->$attribute;

        $isbn = preg_replace('/[-\s]/', '', $originalIsbn);

        if (!preg_match('/^[0-9X]+$/', $isbn)) {
            $this->addError($attribute, 'ISBN может содержать только цифры и X (для ISBN-10).');
            return;
        }

        if (strlen($isbn) === 10) {
            if (!preg_match('/^[0-9]{9}[0-9X]$/', $isbn)) {
                $this->addError($attribute, 'ISBN-10 должен содержать 9 цифр и одну цифру или X в конце.');
            }
        } elseif (strlen($isbn) === 13) {
            if (!preg_match('/^[0-9]{13}$/', $isbn)) {
                $this->addError($attribute, 'ISBN-13 должен содержать 13 цифр.');
            }
        } else {
            $this->addError($attribute, 'ISBN должен содержать 10 или 13 символов.');
        }
    }

    /**
     * Gets the book cover service
     * 
     * @return BookCoverService
     */
    public function getCoverService(): BookCoverService
    {
        return new BookCoverService();
    }

    /**
     * Uploads a cover file
     * 
     * @return bool True if upload was successful
     */
    public function upload(): bool
    {
        if (!$this->coverFile) {
            return false;
        }

        $coverService = $this->getCoverService();
        
        if (!$coverService->validateFile($this->coverFile)) {
            $this->addError('coverFile', 'Недопустимый тип файла');
            return false;
        }

        $coverPath = $coverService->uploadCover($this->id, $this->coverFile);
        
        if ($coverPath) {
            $this->cover_image = $coverPath;
            return true;
        }

        return false;
    }

    /**
     * Gets the cover URL
     * 
     * @return string|null The cover URL or null
     */
    public function getCoverUrl(): ?string
    {
        if (empty($this->cover_image)) {
            return null;
        }
        return $this->getCoverService()->getCoverUrl($this->cover_image);
    }

    /**
     * Gets the thumbnail URL
     * 
     * @return string|null The thumbnail URL or null
     */
    public function getThumbnailUrl(): ?string
    {
        if (empty($this->cover_image)) {
            return null;
        }
        return $this->getCoverService()->getThumbnailUrl($this->cover_image);
    }

    /**
     * Deletes the cover files
     * 
     * @return void
     */
    public function deleteCover(): void
    {
        $this->getCoverService()->deleteCover($this->cover_image);
        $this->cover_image = null;
    }

}
