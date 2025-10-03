<?php

use yii\db\Migration;

class m251003_100003_create_book_authors_table_final extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book_authors}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-book_authors-book_id',
            '{{%book_authors}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book_authors-author_id',
            '{{%book_authors}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex('idx-book_authors-book_id', '{{%book_authors}}', 'book_id');
        $this->createIndex('idx-book_authors-author_id', '{{%book_authors}}', 'author_id');
        $this->createIndex('idx-book_authors-unique', '{{%book_authors}}', ['book_id', 'author_id'], true);
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-book_authors-book_id', '{{%book_authors}}');
        $this->dropForeignKey('fk-book_authors-author_id', '{{%book_authors}}');
        $this->dropTable('{{%book_authors}}');
    }
}
