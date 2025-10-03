<?php

/**
 * Environment variables configuration
 * Copy this file to .env and modify values as needed
 */

return [
    // Database Configuration
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'test-books-store', 
    'DB_USER' => 'root',
    'DB_PASSWORD' => 'root',

    // Application Configuration
    'APP_SECRET' => 'app-secret-key-for-development',
    // SMS Configuration
    'SMS_API_KEY' => 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ',
    'SMS_API_URL' => 'https://smspilot.ru/api.php',
    'SMS_SENDER' => 'BOOKS',
    'SMS_TEST_MODE' => 'true',

    // Environment
    'YII_ENV' => 'dev',
    'YII_DEBUG' => 'true',
];
