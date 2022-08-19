<?php

namespace App\Integration\DataTransformer;

use App\Integration\DTO\AuthCredential;
use App\Interfaces\DataTransformer\AuthCredentialTransformerInterface;

class AuthCredentialTransformer implements AuthCredentialTransformerInterface
{
    public function transform(string $apiKey): AuthCredential
    {
        return new AuthCredential($apiKey);
    }

    public function reverseTransform(AuthCredential $authCredential): string
    {
        return $authCredential->apiKey;
    }
}
