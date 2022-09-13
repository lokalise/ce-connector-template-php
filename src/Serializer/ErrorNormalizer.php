<?php

namespace App\Serializer;

use App\Enum\ErrorCodeEnum;
use App\Exception\PublicNonRecoverableException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ErrorNormalizer implements NormalizerInterface
{
    /**
     * @param FlattenException $object
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        if (!$object instanceof FlattenException) {
            throw new InvalidArgumentException(
                sprintf('The object must implement "%s".', FlattenException::class),
            );
        }

        ['exception' => $exception] = $context;

        $payload = $exception instanceof PublicNonRecoverableException ? [
            'errorCode' => $exception->getErrorCode()->value,
            'details' => $exception->getDetails(),
        ] : [
            'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR,
            'details' => [],
        ];

        $payload['message'] = $object->getMessage();

        return [
            'statusCode' => $object->getStatusCode(),
            'payload' => $payload,
        ];
    }

    public function supportsNormalization(mixed $data, string $format = null): bool
    {
        return $data instanceof FlattenException;
    }
}
