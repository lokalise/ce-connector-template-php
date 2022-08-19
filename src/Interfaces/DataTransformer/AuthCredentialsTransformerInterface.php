<?php

namespace App\Interfaces\DataTransformer;

use App\Integration\DTO\AuthCredentials;

interface AuthCredentialsTransformerInterface
{
    public function transform(string $apiKey): AuthCredentials;

    public function reverseTransform(AuthCredentials $authCredential): string;
}
