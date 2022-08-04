<?php

namespace App\Integration\Renderer;

use App\DTO\Response\AuthResponse;
use App\Interfaces\Renderer\AuthRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthRenderer implements AuthRendererInterface
{
    public function render(string $key): Response
    {
        $responseDTO = new AuthResponse($key);

        return new JsonResponse($responseDTO);
    }
}
