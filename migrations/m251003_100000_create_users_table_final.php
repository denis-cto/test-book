<?php

use yii\db\Migration;

class m251003_100000_create_users_table_final extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull()->unique(),
            'email' => $this->string(255)->notNull()->unique(),
            'password_hash' => $this->string(255)->notNull(),
            'phone' => $this->string(20)->null(),
            'auth_key' => $this->string(32)->notNull(),
            'password_reset_token' => $this->string(255)->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-users-username', '{{%users}}', 'username');
        $this->createIndex('idx-users-email', '{{%users}}', 'email');
        $this->createIndex('idx-users-phone', '{{%users}}', 'phone');
    }

    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
