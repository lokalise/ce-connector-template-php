<?php

namespace App\DTO;

use App\Enum\PerLocaleErrorCodeEnum;

class PerLocaleError
{
    public function __construct(
        public readonly ?array $userErrors = null,
        public readonly ?PerLocaleErrorCodeEnum $errorCode = null,
    ) {
    }
}
