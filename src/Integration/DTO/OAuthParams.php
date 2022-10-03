<?php

namespace App\Integration\DTO;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Parameters that the 3rd party service sends to the redirect URL during OAuth authorization.
 */
class OAuthParams
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly ?string $code = null,
    ) {
    }
}
