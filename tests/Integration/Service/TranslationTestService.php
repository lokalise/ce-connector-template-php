<?php

namespace App\Tests\Integration\Service;

use App\DTO\ContentItem;
use App\DTO\UniqueItemIdentifier;
use App\Interfaces\TranslationInterface;
use JetBrains\PhpStorm\ArrayShape;

class TranslationTestService implements TranslationInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, UniqueItemIdentifier> $items
     *
     * @return array<int, ContentItem>|null
     */
    public function getContent(string $accessToken, array $locales, array $items): ?array
    {
        return array_map(
            function (UniqueItemIdentifier $uniqueItemIdentifier) use ($locales): ContentItem {
                $contentItem = new ContentItem();
                $contentItem->uniqueId = $uniqueItemIdentifier->uniqueId;
                $contentItem->groupId = $uniqueItemIdentifier->groupId;
                $contentItem->metadata = $uniqueItemIdentifier->metadata;
                $contentItem->translations = array_combine($locales, $locales);

                return $contentItem;
            },
            $items
        );
    }
}
