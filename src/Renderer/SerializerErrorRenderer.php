<?php

namespace App\Renderer;

use App\DTO\UnrecognizedError;
use App\Enum\ErrorCodeEnum;
use App\Exception\HttpException;
use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerErrorRenderer implements ErrorRendererInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ErrorRendererFactory $errorRendererFactory,
    ) {
    }

    public function render(\Throwable $exception): FlattenException
    {
        if (!$exception instanceof HttpException) {
            $exception = new HttpException(
                'Unrecognized error',
                Response::HTTP_INTERNAL_SERVER_ERROR,
                ErrorCodeEnum::UNRECOGNIZED_ERROR,
                [
                    new UnrecognizedError($exception->getMessage()),
                ],
            );
        }

        $flattenException = FlattenException::createFromThrowable($exception);

        $responseDTO = $this->errorRendererFactory
            ->factory($exception)
            ->render($exception);

        $response = $this->serializer->serialize($responseDTO, JsonEncoder::FORMAT, [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
        ]);

        $headers = [
            'Content-Type' => Request::getMimeTypes(JsonEncoder::FORMAT)[0] ?? JsonEncoder::FORMAT,
        ];

        return $flattenException
            ->setAsString($response)
            ->setHeaders($flattenException->getHeaders() + $headers);
    }
}
