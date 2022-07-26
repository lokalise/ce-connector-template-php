<?php

namespace App\Integration;

use App\DTO\ContentItem;
use App\DTO\Response\TranslationResponse;
use App\Interfaces\TranslationRendererInterface;
use JetBrains\PhpStorm\ArrayShape;

class TranslationRenderer implements TranslationRendererInterface
{
    public function render(array $items): TranslationResponse
    {
        $resultItems = array_map(function (
            #[ArrayShape([
                'uniqueId' => 'string',
                'groupId' => 'string',
                'metadata' => 'array',
                'translations' => 'array',
            ])]
            array $item,
        ) {
            $contentItem = new ContentItem();
            $contentItem->uniqueId = $item['uniqueId'];
            $contentItem->groupId = $item['groupId'];
            $contentItem->metadata = $item['metadata'] ?? [];
            $contentItem->translations = $item['translations'] ?? [];

            return $contentItem;
        }, $items);

        return new TranslationResponse($resultItems);
    }
}
