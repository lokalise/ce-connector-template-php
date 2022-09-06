<?php

namespace App\Integration\DataTransformer;

use App\Integration\DTO\AuthCredentials;
use App\Interfaces\DataTransformer\AuthCredentialsTransformerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class AuthCredentialsTransformer implements AuthCredentialsTransformerInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function transform(string $apiKey): AuthCredentials
    {
        $apiKeyJson = base64_decode($apiKey, true);

        return $this->serializer->deserialize(
            $apiKeyJson,
            AuthCredentials::class,
            JsonEncoder::FORMAT,
        );
    }

    public function reverseTransform(AuthCredentials $credentials): string
    {
        $credentialsJson = $this->serializer->serialize($credentials, JsonEncoder::FORMAT);

        return base64_encode($credentialsJson);
    }
}
