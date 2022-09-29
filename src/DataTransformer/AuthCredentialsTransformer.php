<?php

namespace App\DataTransformer;

use App\Integration\DTO\AuthCredentials;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * The transformer decodes the authorization header and creates an object of type {@link AuthCredentials}.
 */
class AuthCredentialsTransformer
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
}
