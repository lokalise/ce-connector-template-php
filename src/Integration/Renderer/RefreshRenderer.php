<?php

namespace App\Integration\Renderer;

use App\DTO\Response\RefreshResponse;
use App\Interfaces\Renderer\RefreshRendererInterface;
use App\Renderer\JsonResponseRenderer;
use Symfony\Component\HttpFoundation\Response;

class RefreshRenderer implements RefreshRendererInterface
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    public function render(string $refreshKey): Response
    {
        $responseDTO = new RefreshResponse($refreshKey);

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
