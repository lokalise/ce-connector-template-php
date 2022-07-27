<?php

namespace App\DTO\Response;

use App\DTO\ContentItem;

class TranslationResponse
{
    /**
     * @param array<int, ContentItem> $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
