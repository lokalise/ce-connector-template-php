<?php

namespace App\DTO\Response;

use App\DTO\TranslationItem;

class TranslationResponse implements ResponseDTO
{
    /**
     * @param array<int, TranslationItem> $items
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
