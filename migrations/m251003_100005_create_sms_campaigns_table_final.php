<?php

use yii\db\Migration;

class m251003_100005_create_sms_campaigns_table_final extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%sms_campaigns}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'total_recipients' => $this->integer()->notNull()->defaultValue(0),
            'sent_successfully' => $this->integer()->notNull()->defaultValue(0),
            'sent_failed' => $this->integer()->notNull()->defaultValue(0),
            'message' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-sms_campaigns-book_id', '{{%sms_campaigns}}', 'book_id');
        $this->createIndex('idx-sms_campaigns-author_id', '{{%sms_campaigns}}', 'author_id');
        $this->createIndex('idx-sms_campaigns-created_at', '{{%sms_campaigns}}', 'created_at');

        $this->addForeignKey(
            'fk-sms_campaigns-book_id',
            '{{%sms_campaigns}}',
            'book_id',
            '{{%books}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sms_campaigns-author_id',
            '{{%sms_campaigns}}',
            'author_id',
            '{{%authors}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%sms_campaigns}}');
    }
}
