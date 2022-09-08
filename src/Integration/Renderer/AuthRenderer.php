<?php

namespace App\Integration\Renderer;

use App\DTO\Response\AuthCredentialsResponse;
use App\DTO\Response\AuthUrlResponse;
use App\Integration\DTO\OAuthClientToken;
use App\Interfaces\Renderer\AuthRendererInterface;
use App\Renderer\JsonResponseRenderer;
use Symfony\Component\HttpFoundation\Response;

class AuthRenderer implements AuthRendererInterface
{
    public function __construct(
        private readonly JsonResponseRenderer $jsonResponseRenderer,
    ) {
    }

    public function renderKey(string $key): Response
    {
        $responseDTO = new AuthCredentialsResponse($key);

        return $this->jsonResponseRenderer->render($responseDTO);
    }

    public function renderUrl(string $url): Response
    {
        $responseDTO = new AuthUrlResponse($url);

        return $this->jsonResponseRenderer->render($responseDTO);
    }

    public function renderAccessCredentials(OAuthClientToken $token): Response
    {
        $responseDTO = new AuthCredentialsResponse(
            accessToken: $token->accessToken,
            refreshToken: $token->refreshToken,
            expiresIn: $token->expiresIn,
        );

        return $this->jsonResponseRenderer->render($responseDTO);
    }
}
