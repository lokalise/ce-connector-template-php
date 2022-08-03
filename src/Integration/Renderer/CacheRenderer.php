<?php

namespace App\Integration\Renderer;

use App\DTO\Response\CacheResponse;
use App\DTO\UniqueItemIdentifier;
use App\Interfaces\Renderer\CacheRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CacheRenderer implements CacheRendererInterface
{
    /**
     * @param array<int, UniqueItemIdentifier> $items
     */
    public function render(array $items): Response
    {
        $responseDTO = new CacheResponse($items);

        return new JsonResponse($responseDTO);
    }
}