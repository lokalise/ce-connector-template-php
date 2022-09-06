<?php

namespace App\Integration\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class OAuthClientToken
{
    public function __construct(
        #[SerializedName('access_token')]
        public readonly string $accessToken,
        #[SerializedName('refresh_token')]
        public readonly string $refreshToken,
        #[SerializedName('expires_in')]
        public readonly int $expiresIn,
    ) {
    }
}
