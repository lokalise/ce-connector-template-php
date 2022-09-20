<?php

namespace App\Interfaces\Renderer;

use App\Integration\DTO\AuthCredentials;
use Symfony\Component\HttpFoundation\Response;

interface AuthRendererInterface
{
    public function renderUrl(string $url): Response;

    public function renderAuthCredentials(AuthCredentials $token): Response;
}
