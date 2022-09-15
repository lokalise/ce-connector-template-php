<?php

namespace App\Integration\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class AuthCredentials
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly ?string $apiKey = null,
    ) {
    }

    public static function createFromAuthCredentials(AuthCredentials $credentials): static
    {
        return new static(
            $credentials->apiKey,
        );
    }
}
