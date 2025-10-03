<?php

namespace app\exceptions;

use Exception;

class ValidationException extends Exception
{
    private $errors;

    public function __construct(array $errors, string $message = 'Validation failed', int $code = 0, Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
