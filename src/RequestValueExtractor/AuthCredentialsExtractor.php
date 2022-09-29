<?php

namespace App\RequestValueExtractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * Extracts the authorization header from the request.
 */
class AuthCredentialsExtractor implements RequestValueExtractorInterface
{
    public const AUTH_CREDENTIALS_HEADER = 'CE-Auth';

    public function extract(Request $request): ?string
    {
        $authCredentialsHeader = strtolower(self::AUTH_CREDENTIALS_HEADER);

        return $request->headers->get($authCredentialsHeader);
    }
}
