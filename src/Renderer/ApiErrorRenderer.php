<?php

namespace App\Renderer;

use App\DTO\Response\ApiErrorResponse;
use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiErrorRenderer implements ErrorRendererInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function render(\Throwable $exception): FlattenException
    {
        $flattenException = FlattenException::createFromThrowable($exception);

        $responseDTO = new ApiErrorResponse(
            $flattenException->getStatusCode(),
            $flattenException->getMessage(),
        );

        $serializedResponse = $this->serializer->serialize($responseDTO, JsonEncoder::FORMAT);

        return $flattenException->setAsString($serializedResponse)->setHeaders([
            'Content-Type' => Request::getMimeTypes(JsonEncoder::FORMAT)[0],
            'Vary' => 'Accept',
        ]);
    }
}
