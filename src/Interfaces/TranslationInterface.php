<?php

namespace App\Interfaces;

use App\DTO\ContentItem;
use App\DTO\UniqueItemIdentifier;

interface TranslationInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, UniqueItemIdentifier> $items
     *
     * @return array<int, ContentItem>|null
     */
    public function getContent(string $accessToken, array $locales, array $items): ?array;
}
