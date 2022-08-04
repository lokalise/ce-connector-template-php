<?php

namespace App\Integration\Renderer;

use App\DTO\EnvItem;
use App\DTO\Response\EnvironmentResponse;
use App\Interfaces\Renderer\EnvironmentRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EnvironmentRenderer implements EnvironmentRendererInterface
{
    public function render(EnvItem $environments): Response
    {
        $responseDTO = new EnvironmentResponse(
            $environments->defaultLocale,
            $environments->locales,
            $environments->cacheItemStructure,
        );

        return new JsonResponse($responseDTO);
    }
}
