<?php

namespace App\DTO\Response;

use App\DTO\ErrorPayload;

class ErrorResponse implements ResponseDTO
{
    public function __construct(
        public readonly int $statusCode,
        public readonly ErrorPayload $payload,
        public readonly ?array $items = null,
    ) {
    }
}
