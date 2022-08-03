<?php

namespace App\Tests\Functional\Integration\Mapper;

use App\DTO\ContentItem;
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
    ): ContentItem {
        $contentItem = new ContentItem();
        $contentItem->uniqueId = $item['uniqueId'];
        $contentItem->groupId = $item['groupId'];
        $contentItem->metadata = $item['metadata'];
        $contentItem->translations = $item['translations'];

        return $contentItem;
    }
}