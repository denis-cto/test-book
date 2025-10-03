<?php

use yii\db\Migration;

class m251003_100004_create_subscriptions_table_final extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%subscriptions}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(20)->null(),
            'is_active' => $this->boolean()->notNull()->defaultValue(true),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-subscriptions-author_id',
            '{{%subscriptions}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE'
        );

        $this->createIndex('idx-subscriptions-author_id', '{{%subscriptions}}', 'author_id');
        $this->createIndex('idx-subscriptions-phone', '{{%subscriptions}}', 'phone');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-subscriptions-author_id', '{{%subscriptions}}');
        $this->dropTable('{{%subscriptions}}');
    }
}
