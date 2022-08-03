<?php

namespace App\Interfaces\Renderer;

use App\DTO\CacheItem;
use Symfony\Component\HttpFoundation\Response;

interface CacheItemRendererInterface
{
    /**
     * @param array<int, CacheItem> $items
     */
    public function render(array $items): Response;
}