<?php

namespace App\Integration\Renderer;

use App\DTO\EnvItem;
use App\DTO\Response\EnvironmentResponse;
use App\Interfaces\Renderer\EnvironmentRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EnvironmentRenderer implements EnvironmentRendererInterface
{
    /**
     * @param array<int, EnvItem> $environments
     */
    public function render(array $environments): Response
    {
        $responseDTO = new EnvironmentResponse($environments);

        return new JsonResponse($responseDTO);
    }
}