<?php

namespace App\DTO;

use App\Enum\AuthTypeEnum;
use App\Validator\NotBlank;

class AccessCredentials
{
    public function __construct(
        #[NotBlank(groups: [AuthTypeEnum::OAuth])]
        public readonly ?string $accessToken = null,
        #[NotBlank(groups: [AuthTypeEnum::OAuth])]
        public readonly ?string $refreshToken = null,
        public readonly ?int $expiresIn = null,
    ) {
    }
}
