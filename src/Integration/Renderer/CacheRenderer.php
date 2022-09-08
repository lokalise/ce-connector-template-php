<?php

namespace App\Integration\Renderer;

use App\DTO\Response\CacheResponse;
use App\DTO\Identifier;
use App\Interfaces\Renderer\CacheRendererInterface;
use App\Renderer\JsonResponseRenderer;
use Symfony\Component\HttpFoundation\Response;

class CacheRenderer implements CacheRendererInterface
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
