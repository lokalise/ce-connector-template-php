<?php

namespace App\Interfaces;

use App\DTO\ContentItem;

interface TranslationInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, ContentItem> $items
     */
    public function getContent(string $accessToken, array $locales, array $items): ?array;
}