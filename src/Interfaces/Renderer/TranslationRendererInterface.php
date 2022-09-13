<?php

namespace App\Interfaces\Renderer;

use App\DTO\ErrorItem;
use App\DTO\TranslationItem;
use Symfony\Component\HttpFoundation\Response;

interface TranslationRendererInterface
{
    /**
     * @param array<int, TranslationItem> $items
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function render(array $items, ?string $errorMessage = null, array $errors = []): Response;
}
