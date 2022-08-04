<?php

namespace App\Tests\Functional\Integration\Mapper;

use App\DTO\TranslationItem;
use App\Interfaces\Mapper\TranslationItemMapperInterface;
use JetBrains\PhpStorm\ArrayShape;

class TranslationItemMapper implements TranslationItemMapperInterface
{
    public function mapArrayToTranslationItem(
        #[ArrayShape([
            'uniqueId' => 'string',
            'groupId' => 'string',
            'metadata' => 'string[]',
            'translations' => 'string[]',
        ])]
        array $item,
    ): TranslationItem {
        $translationItem = new TranslationItem();
        $translationItem->uniqueId = $item['uniqueId'];
        $translationItem->groupId = $item['groupId'];
        $translationItem->metadata = $item['metadata'];
        $translationItem->translations = $item['translations'];

        return $translationItem;
    }
}
