<?php

namespace App\Serializer;

use App\Enum\ErrorCodeEnum;
use App\Exception\HttpException;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Converts errors to a common format.
 */
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

        $payload = $exception instanceof HttpException ? array_filter([
            'errorCode' => $exception->getErrorCode()->value,
            'details' => $exception->getDetails()?->toArray(),
        ]) : [
            'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR,
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
