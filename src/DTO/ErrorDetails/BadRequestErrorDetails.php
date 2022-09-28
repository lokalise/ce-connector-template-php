<?php

namespace App\DTO\ErrorDetails;

class BadRequestErrorDetails implements ErrorDetailsDTO
{
    /**
     * @param array<int, array<string, array<int, string>>> $errors
     */
    public function __construct(
        private readonly array $errors = [],
    ) {
    }

    /**
     * @return array<int, array<string, array<int, string>>>
     */
    public function toArray(): array
    {
        return [
            'errors' => $this->errors,
        ];
    }
}
