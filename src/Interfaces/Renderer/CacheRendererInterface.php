<?php

namespace App\Interfaces\Renderer;

use App\DTO\UniqueItemIdentifier;
use Symfony\Component\HttpFoundation\Response;

interface CacheRendererInterface
{
    /**
     * @param array<int, UniqueItemIdentifier> $items
     */
    public function render(array $items): Response;
}