<?php

namespace App\Integration\DTO;

use App\Enum\AuthTypeEnum;
use App\Validator\NotBlank;

class AuthCredentials
{
    public function __construct(
        #[NotBlank(groups: [AuthTypeEnum::apiKey])]
        public readonly ?string $apiKey = null,
        #[NotBlank(groups: [AuthTypeEnum::OAuth])]
        public readonly ?string $accessToken = null,
        #[NotBlank(groups: [AuthTypeEnum::OAuth])]
        public readonly ?string $refreshToken = null,
        public readonly ?int $expiresIn = null,
    ) {
    }
}
