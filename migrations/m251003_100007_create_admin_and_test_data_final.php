<?php

use app\models\User;
use yii\db\Migration;

class m251003_100007_create_admin_and_test_data_final extends Migration
{
    public function safeUp(): bool
    {
        // Clear existing data to ensure clean test data
        $this->delete('{{%book_authors}}');
        $this->delete('{{%books}}');
        $this->delete('{{%authors}}');
        User::deleteAll(['username' => 'admin']);
        
        // Reset auto-increment counters to start from 1
        $this->execute('ALTER TABLE {{%authors}} AUTO_INCREMENT = 1');
        $this->execute('ALTER TABLE {{%books}} AUTO_INCREMENT = 1');

        $admin = new User();
        $admin->username = 'admin';
        $admin->email = 'admin@example.com';
        $admin->setPassword('admin');
        $admin->generateAuthKey();
        $admin->status = User::STATUS_ACTIVE;
        $admin->save();


        $this->insert('{{%authors}}', [
            'first_name' => 'Александр',
            'last_name' => 'Пушкин',
            'middle_name' => 'Сергеевич',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Лев',
            'last_name' => 'Толстой',
            'middle_name' => 'Николаевич',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Фёдор',
            'last_name' => 'Достоевский',
            'middle_name' => 'Михайлович',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Николай',
            'last_name' => 'Гоголь',
            'middle_name' => 'Васильевич',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Антон',
            'last_name' => 'Чехов',
            'middle_name' => 'Павлович',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Иван',
            'last_name' => 'Тургенев',
            'middle_name' => 'Сергеевич',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Михаил',
            'last_name' => 'Лермонтов',
            'middle_name' => 'Юрьевич',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Николай',
            'last_name' => 'Некрасов',
            'middle_name' => 'Алексеевич',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Александр',
            'last_name' => 'Грибоедов',
            'middle_name' => 'Сергеевич',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Владимир',
            'last_name' => 'Маяковский',
            'middle_name' => 'Владимирович',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Сергей',
            'last_name' => 'Есенин',
            'middle_name' => 'Александрович',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%authors}}', [
            'first_name' => 'Анна',
            'last_name' => 'Ахматова',
            'middle_name' => 'Андреевна',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Евгений Онегин',
            'year' => 2020,
            'description' => 'Роман в стихах Александра Пушкина',
            'isbn' => '978-5-699-12345-6',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Капитанская дочка',
            'year' => 2020,
            'description' => 'Исторический роман Александра Пушкина',
            'isbn' => '978-5-699-12346-7',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Война и мир',
            'year' => 2021,
            'description' => 'Роман-эпопея Льва Толстого',
            'isbn' => '978-5-699-12347-8',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Анна Каренина',
            'year' => 2021,
            'description' => 'Роман Льва Толстого',
            'isbn' => '978-5-699-12348-9',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Преступление и наказание',
            'year' => 2022,
            'description' => 'Роман Фёдора Достоевского',
            'isbn' => '978-5-699-12349-0',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Братья Карамазовы',
            'year' => 2022,
            'description' => 'Роман Фёдора Достоевского',
            'isbn' => '978-5-699-12350-1',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Мёртвые души',
            'year' => 2023,
            'description' => 'Поэма Николая Гоголя',
            'isbn' => '978-5-699-12351-2',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Ревизор',
            'year' => 2023,
            'description' => 'Комедия Николая Гоголя',
            'isbn' => '978-5-699-12352-3',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Вишнёвый сад',
            'year' => 2024,
            'description' => 'Пьеса Антона Чехова',
            'isbn' => '978-5-699-12353-4',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Три сестры',
            'year' => 2024,
            'description' => 'Пьеса Антона Чехова',
            'isbn' => '978-5-699-12354-5',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Отцы и дети',
            'year' => 2025,
            'description' => 'Роман Ивана Тургенева',
            'isbn' => '978-5-699-12355-6',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Дворянское гнездо',
            'year' => 2025,
            'description' => 'Роман Ивана Тургенева',
            'isbn' => '978-5-699-12356-7',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Герой нашего времени',
            'year' => 2020,
            'description' => 'Роман Михаила Лермонтова',
            'isbn' => '978-5-699-12357-8',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Мцыри',
            'year' => 2020,
            'description' => 'Поэма Михаила Лермонтова',
            'isbn' => '978-5-699-12358-9',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Кому на Руси жить хорошо',
            'year' => 2021,
            'description' => 'Поэма Николая Некрасова',
            'isbn' => '978-5-699-12359-0',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Горе от ума',
            'year' => 2021,
            'description' => 'Комедия Александра Грибоедова',
            'isbn' => '978-5-699-12360-1',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Облако в штанах',
            'year' => 2022,
            'description' => 'Поэма Владимира Маяковского',
            'isbn' => '978-5-699-12361-2',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Анна Снегина',
            'year' => 2023,
            'description' => 'Поэма Сергея Есенина',
            'isbn' => '978-5-699-12362-3',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Реквием',
            'year' => 2024,
            'description' => 'Поэма Анны Ахматовой',
            'isbn' => '978-5-699-12363-4',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%books}}', [
            'title' => 'Мастер и Маргарита',
            'year' => 2025,
            'description' => 'Роман Михаила Булгакова',
            'isbn' => '978-5-699-12364-5',
            'cover_image' => '',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 1,
            'author_id' => 1,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 2,
            'author_id' => 1,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 3,
            'author_id' => 2,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 4,
            'author_id' => 2,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 5,
            'author_id' => 3,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 6,
            'author_id' => 3,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 7,
            'author_id' => 4,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 8,
            'author_id' => 4,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 9,
            'author_id' => 5,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 10,
            'author_id' => 5,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 11,
            'author_id' => 6,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 12,
            'author_id' => 6,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 13,
            'author_id' => 7,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 14,
            'author_id' => 7,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 15,
            'author_id' => 8,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 16,
            'author_id' => 9,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 17,
            'author_id' => 10,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 18,
            'author_id' => 11,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 19,
            'author_id' => 12,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 20,
            'author_id' => 1,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 1,
            'author_id' => 2,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 3,
            'author_id' => 3,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 5,
            'author_id' => 4,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 7,
            'author_id' => 5,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 9,
            'author_id' => 6,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 11,
            'author_id' => 7,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 13,
            'author_id' => 8,
            'created_at' => time(),
        ]);

        $this->insert('{{%book_authors}}', [
            'book_id' => 15,
            'author_id' => 9,
            'created_at' => time(),
        ]);
        
        return true;
    }

    public function safeDown(): bool
    {
        User::deleteAll(['username' => 'admin']);

        $this->delete('{{%book_authors}}');
        $this->delete('{{%books}}');
        $this->delete('{{%authors}}');
    }
}
