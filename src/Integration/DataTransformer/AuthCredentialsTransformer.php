<?php

namespace App\Integration\DataTransformer;

use App\Integration\DTO\AccessCredentials;
use App\Interfaces\DataTransformer\AuthCredentialsTransformerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class AuthCredentialsTransformer implements AuthCredentialsTransformerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function transform(string $apiKey): AccessCredentials
    {
        $apiKeyJson = base64_decode($apiKey, true);

        return $this->serializer->deserialize(
            $apiKeyJson,
            AccessCredentials::class,
            JsonEncoder::FORMAT,
        );
    }

    public function reverseTransform(AccessCredentials $credentials): string
    {
        $credentialsJson = $this->serializer->serialize($credentials, JsonEncoder::FORMAT);

        return base64_encode($credentialsJson);
    }
}
