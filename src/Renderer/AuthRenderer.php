<?php

namespace App\Renderer;

use App\DTO\Response\AuthCredentialsResponse;
use App\DTO\Response\AuthUrlResponse;
use App\Integration\DTO\AuthCredentials;
use Symfony\Component\HttpFoundation\Response;

class AuthRenderer
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    public function renderUrl(string $url): Response
    {
        $responseDTO = new AuthUrlResponse($url);

        return $this->jsonResponseRenderer->render($responseDTO);
    }

    public function renderAuthCredentials(AuthCredentials $credentials): Response
    {
        $responseDTO = AuthCredentialsResponse::createFromAuthCredentials($credentials);

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
