<?php

namespace App\Integration\Renderer;

use App\DTO\Response\RefreshResponse;
use App\Interfaces\Renderer\RefreshRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RefreshRenderer implements RefreshRendererInterface
{
    public function render(string $refreshKey): Response
    {
        $responseDTO = new RefreshResponse($refreshKey);

        return new JsonResponse($responseDTO);
    }
}
