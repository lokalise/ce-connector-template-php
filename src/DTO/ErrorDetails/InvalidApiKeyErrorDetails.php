<?php

namespace App\DTO\ErrorDetails;

class InvalidApiKeyErrorDetails implements ErrorDetailsDTO
{
    public function toArray(): array
    {
        return [
            'error' => 'Invalid api key',
        ];
    }
}
