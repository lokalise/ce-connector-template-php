<?php

namespace App\Renderer;

use App\DTO\Response\AuthMethodResponse;
use App\Enum\AuthTypeEnum;
use Symfony\Component\HttpFoundation\Response;

class AuthMethodRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
        private readonly AuthTypeEnum $defaultAuthType,
    ) {
    }

    public function render(): Response
    {
        $responseDTO = new AuthMethodResponse($this->defaultAuthType);

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
