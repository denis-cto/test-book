<?php

use yii\db\Migration;

class m251003_100001_create_authors_table_final extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(100)->notNull(),
            'last_name' => $this->string(100)->notNull(),
            'middle_name' => $this->string(100)->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-authors-name', '{{%authors}}', ['last_name', 'first_name', 'middle_name']);
    }

    public function safeDown()
    {
        $this->dropTable('{{%authors}}');
    }
}
