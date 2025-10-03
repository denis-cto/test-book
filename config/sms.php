<?php

/**
 * SMS Configuration
 * Contains all SMS-related settings
 */

return [
    'class' => 'app\components\SmsComponent',
    'apiKey' => $_ENV['SMS_API_KEY'] ?? 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ',
    'apiUrl' => $_ENV['SMS_API_URL'] ?? 'https://smspilot.ru/api.php',
    'sender' => $_ENV['SMS_SENDER'] ?? 'BOOKS',
    'testMode' => filter_var($_ENV['SMS_TEST_MODE'] ?? 'true', FILTER_VALIDATE_BOOLEAN),
];
