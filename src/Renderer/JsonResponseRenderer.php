<?php

namespace App\Renderer;

use App\DTO\ErrorItem;
use App\DTO\Response\ResponseDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonResponseRenderer
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    /**
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function render(ResponseDTO $responseDTO, ?string $errorMessage = null, array $errors = []): JsonResponse
    {
        $context = [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
        ];

        if ($errorMessage === null && empty($errors)) {
            return new JsonResponse(
                data: $this->serializer->serialize($responseDTO, JsonEncoder::FORMAT, $context),
                json: true,
            );
        }

        $normalizedResponse = $this->serializer->normalize($responseDTO, JsonEncoder::FORMAT, $context);

        $normalizedResponse['code'] = Response::HTTP_MULTI_STATUS;

        if ($errorMessage !== null) {
            $normalizedResponse['message'] = $errorMessage;
        }

        foreach ($errors as $errorItems) {
            $normalizedErrors = [];
            foreach ($errorItems as $key => $errorItem) {
                $normalizedErrors[$key] = $this->serializer->normalize($errorItem, JsonEncoder::FORMAT, $context);
            }

            $normalizedResponse['errors'][] = $normalizedErrors;
        }

        return new JsonResponse(
            data: $this->serializer->encode($normalizedResponse, JsonEncoder::FORMAT, $context),
            status: Response::HTTP_MULTI_STATUS,
            json: true,
        );
    }
}
