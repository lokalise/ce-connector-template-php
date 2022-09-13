<?php

namespace App\Renderer;

use App\DTO\EnvItem;
use App\DTO\Response\EnvironmentResponse;
use App\Interfaces\Renderer\EnvironmentRendererInterface;
use Symfony\Component\HttpFoundation\Response;

class EnvironmentRenderer implements EnvironmentRendererInterface
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    public function render(EnvItem $environments): Response
    {
        $responseDTO = new EnvironmentResponse(
            $environments->defaultLocale,
            $environments->locales,
            $environments->cacheItemStructure,
        );

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
