<?php

namespace App\Integration\DataTransformer;

use App\Integration\DTO\AuthCredentials;
use App\Interfaces\DataTransformer\AuthCredentialsTransformerInterface;

class AuthCredentialsTransformer implements AuthCredentialsTransformerInterface
{
    public function transform(string $apiKey): AuthCredentials
    {
        return new AuthCredentials($apiKey);
    }

    public function reverseTransform(AuthCredentials $authCredential): string
    {
        return $authCredential->apiKey;
    }
}
