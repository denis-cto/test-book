<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'mysql:host=' . (getenv('DB_HOST') ?: 'localhost') . ';dbname=' . (getenv('DB_TEST_NAME') ?: 'test-books-store-test');
$db['username'] = getenv('DB_USER') ?: 'root';
$db['password'] = getenv('DB_PASSWORD') ?: 'root';

return $db;
