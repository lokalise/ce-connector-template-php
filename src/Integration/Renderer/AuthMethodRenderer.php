<?php

namespace App\Integration\Renderer;

use App\DTO\Response\AuthMethodResponse;
use App\Enum\AuthTypeEnum;
use App\Interfaces\Renderer\AuthMethodRendererInterface;
use App\Renderer\JsonResponseRenderer;
use Symfony\Component\HttpFoundation\Response;

class AuthMethodRenderer implements AuthMethodRendererInterface
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    public function render(AuthTypeEnum $authType): Response
    {
        $responseDTO = new AuthMethodResponse($authType);

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
