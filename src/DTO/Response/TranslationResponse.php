<?php

namespace App\DTO\Response;

use App\DTO\TranslationItem;

class TranslationResponse
{
    /**
     * @param array<int, TranslationItem> $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
