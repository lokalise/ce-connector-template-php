<?php

namespace App\DTO\Response;

use App\Enum\AuthTypeEnum;

class AuthMethodResponse
{
    public function __construct(
        public readonly AuthTypeEnum $type,
    ) {
    }
}
