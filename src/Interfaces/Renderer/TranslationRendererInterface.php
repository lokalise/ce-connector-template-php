<?php

namespace App\Interfaces\Renderer;

use App\DTO\ContentItem;
use Symfony\Component\HttpFoundation\Response;

interface TranslationRendererInterface
{
    /**
     * @param array<int, ContentItem> $items
     */
    public function render(array $items): Response;
}