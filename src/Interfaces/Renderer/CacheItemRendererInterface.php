<?php

namespace App\Interfaces\Renderer;

use App\DTO\CacheItem;
use App\DTO\ErrorItem;
use Symfony\Component\HttpFoundation\Response;

interface CacheItemRendererInterface
{
    /**
     * @param array<int, CacheItem> $items
     * @param array<int, array<string, ErrorItem>> $errors
     */
    public function render(array $items, ?string $errorMessage = null, array $errors = []): Response;
}
