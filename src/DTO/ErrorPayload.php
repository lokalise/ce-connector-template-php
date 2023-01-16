<?php

namespace App\DTO;

use App\Enum\ErrorCodeEnum;

class ErrorPayload
{
    public function __construct(
        public readonly string $message,
        public readonly ErrorCodeEnum $errorCode,
        public readonly ?ErrorDetails $details = null,
    ) {
    }
}
