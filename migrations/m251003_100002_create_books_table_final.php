<?php

use yii\db\Migration;

class m251003_100002_create_books_table_final extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'year' => $this->integer()->notNull(),
            'description' => $this->text()->null(),
            'isbn' => $this->string(20)->null()->unique(),
            'cover_image' => $this->string(500)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-books-title', '{{%books}}', 'title');
        $this->createIndex('idx-books-year', '{{%books}}', 'year');
        $this->createIndex('idx-books-isbn', '{{%books}}', 'isbn');
    }

    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
