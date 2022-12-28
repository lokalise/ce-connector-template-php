<?php

namespace App\Renderer;

use App\DTO\Response\ResponseDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class JsonResponseRenderer
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function render(ResponseDTO $responseDTO): JsonResponse
    {
        return new JsonResponse(
            data: $this->serializer->serialize($responseDTO, JsonEncoder::FORMAT, [
                AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
            ]),
            json: true,
        );
    }
}
