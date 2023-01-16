<?php

namespace App\Integration\DTO;

/**
 * Parameters that the 3rd party service sends to the redirect URL during OAuth authorization.
 */
class OAuthParams
{
    public function __construct(
        public readonly ?string $code = null,
        public readonly ?string $error = null,
    ) {
    }
}
