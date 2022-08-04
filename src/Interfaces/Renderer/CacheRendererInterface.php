<?php

namespace App\Interfaces\Renderer;

use App\DTO\Identifier;
use Symfony\Component\HttpFoundation\Response;

interface CacheRendererInterface
{
    /**
     * @param array<int, Identifier> $items
     */
    public function render(array $items): Response;
}
