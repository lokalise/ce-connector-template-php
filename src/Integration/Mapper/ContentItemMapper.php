<?php

namespace App\Integration\Mapper;

use App\DTO\TranslationItem;
use App\Interfaces\Mapper\ContentItemMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class ContentItemMapper implements ContentItemMapperInterface
{
    public function mapArrayToContentItem(
        #[ArrayShape([
            'uniqueId' => 'string',
            'groupId' => 'string',
            'metadata' => 'string[]',
            'translations' => 'string[]',
        ])]
        array $item,
    ): TranslationItem {
        $contentItem = new TranslationItem();
        $contentItem->uniqueId = $item['uniqueId'];
        $contentItem->groupId = $item['groupId'];
        $contentItem->metadata = $item['metadata'];
        $contentItem->translations = $item['translations'];

        return $contentItem;
    }
}