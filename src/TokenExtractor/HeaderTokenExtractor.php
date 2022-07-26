<?php

namespace App\TokenExtractor;

use Symfony\Component\HttpFoundation\Request;

class HeaderTokenExtractor implements TokenExtractorInterface
{
    public const API_TOKEN_HEADER = 'X-Api-Token';

    public function extract(Request $request): ?string
    {
        $apiTokenHeader = strtolower(self::API_TOKEN_HEADER);

        if (!$request->headers->has($apiTokenHeader)) {
            return null;
        }

        return $request->headers->get($apiTokenHeader);
    }
}