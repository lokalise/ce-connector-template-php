<?php

namespace App\Integration\Renderer;

use App\DTO\Response\AccessCredentialsResponse;
use App\DTO\Response\AuthKeyResponse;
use App\DTO\Response\AuthUrlResponse;
use App\Integration\DTO\OAuthClientToken;
use App\Interfaces\Renderer\AuthRendererInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthRenderer implements AuthRendererInterface
{
    public function renderKey(string $key): Response
    {
        $responseDTO = new AuthKeyResponse($key);

        return new JsonResponse($responseDTO);
    }

    public function renderUrl(string $url): Response
    {
        $responseDTO = new AuthUrlResponse($url);

        return new JsonResponse($responseDTO);
    }

    public function renderAccessCredentials(OAuthClientToken $token): Response
    {
        $responseDTO = new AccessCredentialsResponse(
            $token->accessToken,
            $token->refreshToken,
            $token->expiresIn,
        );

        return new JsonResponse($responseDTO);
    }
}
