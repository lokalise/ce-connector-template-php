<?php

namespace App\Integration\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class OAuthParams
{
    public function __construct(
        #[Assert\NotBlank()]
        public readonly ?string $code = null,
    ) {
    }
}
