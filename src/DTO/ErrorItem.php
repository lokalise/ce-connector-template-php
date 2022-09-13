<?php

namespace App\DTO;

use App\Enum\ErrorCodeEnum;

class ErrorItem
{
    public function __construct(
        public readonly string $message,
        public readonly ?ErrorCodeEnum $errorCode = null,
    ) {
    }
}
