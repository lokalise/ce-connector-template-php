<?php

namespace App\Integration\DTO;

use App\Enum\AuthTypeEnum;
use App\Validator\NotBlank;

class AuthCredentials
{
    public function __construct(
        #[NotBlank(groups: [AuthTypeEnum::apiKey])]
        public readonly ?string $apiKey = null,
    ) {
    }
}
