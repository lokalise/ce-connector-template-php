<?php

namespace App\Interfaces\DataTransformer;

use App\Integration\DTO\AccessCredentials;

interface AuthCredentialsTransformerInterface
{
    public function transform(string $apiKey): AccessCredentials;

    public function reverseTransform(AccessCredentials $credentials): string;
}
