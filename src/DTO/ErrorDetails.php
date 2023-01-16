<?php

namespace App\DTO;

class ErrorDetails
{
    /**
     * @param array<int, BaseErrorInfo|CustomErrorInfo|UnrecognizedError>|null $errors
     */
    public function __construct(
        public readonly ?array $errors = null,
        public readonly ?string $error = null,
    ) {
    }
}
