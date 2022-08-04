<?php

namespace App\Interfaces\Renderer;

use App\DTO\TranslationItem;
use Symfony\Component\HttpFoundation\Response;

interface TranslationRendererInterface
{
    /**
     * @param array<int, TranslationItem> $items
     */
    public function render(array $items): Response;
}