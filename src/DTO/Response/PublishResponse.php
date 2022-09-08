<?php

namespace App\DTO\Response;

class PublishResponse implements ResponseDTO
{
    public function __construct(
        public readonly string $code,
        public readonly string $message,
    ) {
    }
}
