<?php

use yii\db\Migration;

class m251003_100008_fix_books_isbn_unique_constraint extends Migration
{
    public function safeUp(): bool
    {
        // Удаляем уникальный индекс с поля isbn
        $this->dropIndex('idx-books-isbn', '{{%books}}');
        
        // Создаем новый индекс, который позволяет NULL значения
        $this->createIndex('idx-books-isbn', '{{%books}}', 'isbn');
        
        return true;
    }

    public function safeDown(): bool
    {
        // Восстанавливаем уникальный индекс
        $this->dropIndex('idx-books-isbn', '{{%books}}');
        $this->createIndex('idx-books-isbn', '{{%books}}', 'isbn', true);
    }
}
