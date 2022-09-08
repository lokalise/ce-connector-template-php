<?php

namespace App\Interfaces\Renderer;

use App\Integration\DTO\OAuthClientToken;
use Symfony\Component\HttpFoundation\Response;

interface AuthRendererInterface
{
    public function renderKey(string $key): Response;

    public function renderUrl(string $url): Response;

    public function renderAccessCredentials(OAuthClientToken $token): Response;
}
