<?php

namespace App\Renderer;

use App\DTO\CacheItem;
use App\DTO\ErrorItem;
use App\DTO\Response\CacheItemsResponse;
use Symfony\Component\HttpFoundation\Response;

class CacheItemRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    /**
     * @param array<int, CacheItem>                $items
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function render(array $items, ?string $errorMessage = null, array $errors = []): Response
    {
        $responseDTO = new CacheItemsResponse($items);

        return $this->jsonResponseRenderer->render($responseDTO, $errorMessage, $errors);
    }
}
