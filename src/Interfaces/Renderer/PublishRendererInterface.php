<?php

namespace App\Interfaces\Renderer;

use App\DTO\ErrorItem;
use Symfony\Component\HttpFoundation\Response;

interface PublishRendererInterface
{
    /**
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function render(?string $errorMessage = null, array $errors = []): Response;
}
