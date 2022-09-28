<?php

namespace App\Renderer;

use App\DTO\Identifier;
use App\DTO\Response\CacheResponse;
use Symfony\Component\HttpFoundation\Response;

class CacheRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    /**
     * @param array<int, Identifier> $items
     */
    public function render(array $items): Response
    {
        $responseDTO = new CacheResponse($items);

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
