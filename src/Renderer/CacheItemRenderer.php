<?php

namespace App\Renderer;

use App\DTO\CacheItem;
use App\DTO\Response\CacheItemsResponse;
use Symfony\Component\HttpFoundation\Response;

class CacheItemRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    /**
     * @param array<int, CacheItem> $items
     */
    public function render(array $items): Response
    {
        $responseDTO = new CacheItemsResponse($items);

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
