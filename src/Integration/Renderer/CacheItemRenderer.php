<?php

namespace App\Integration\Renderer;

use App\DTO\CacheItem;
use App\DTO\Response\CacheItemsResponse;
use App\Interfaces\Renderer\CacheItemRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CacheItemRenderer implements CacheItemRendererInterface
{
    /**
     * @param array<int, CacheItem> $items
     */
    public function render(array $items): Response
    {
        $responseDTO = new CacheItemsResponse($items);

        return new JsonResponse($responseDTO);
    }
}
