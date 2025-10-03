<?php

/**
 * Application Configuration
 * Contains general application settings
 */

return [
    'appSecret' => $_ENV['APP_SECRET'] ?? 'default-secret-key-for-development',
    'user.passwordResetTokenExpire' => 3600,
    'cookieValidationKey' => $_ENV['COOKIE_VALIDATION_KEY'] ?? 'FQTaPsZL65ktQ-8ZX7ns9RPN0j1VzpnC',
];
