<?php

namespace App\Interfaces\DataTransformer;

use App\Integration\DTO\AuthCredential;

interface AuthCredentialTransformerInterface
{
    public function transform(string $apiKey): AuthCredential;

    public function reverseTransform(AuthCredential $authCredential): string;
}
