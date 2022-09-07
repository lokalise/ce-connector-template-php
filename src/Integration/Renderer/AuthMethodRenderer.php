<?php

namespace App\Integration\Renderer;

use App\DTO\Response\AuthMethodResponse;
use App\Enum\AuthTypeEnum;
use App\Interfaces\Renderer\AuthMethodRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthMethodRenderer implements AuthMethodRendererInterface
{
    public function render(AuthTypeEnum $authType): Response
    {
        $responseDTO = new AuthMethodResponse($authType);

        return new JsonResponse($responseDTO);
    }
}
