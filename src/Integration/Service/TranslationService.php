<?php

namespace App\Integration\Service;

use App\DTO\ContentItem;
use App\DTO\UniqueItemIdentifier;
use App\Interfaces\ApiClientInterface;
use App\Interfaces\Mapper\ContentItemMapperInterface;
use App\Interfaces\Service\TranslationServiceInterface;

class TranslationService implements TranslationServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
        private readonly ContentItemMapperInterface $contentItemMapper,
    ) {
    }

    /**
     * @param array<int, string> $locales
     * @param array<int, UniqueItemIdentifier> $identifiers
     *
     * @return array<int, ContentItem>
     */
    public function getTranslations(string $accessToken, array $locales, array $identifiers): array
    {
        $items = array_map(
            static fn (UniqueItemIdentifier $identifier) => [
                'uniqueId' => $identifier->uniqueId,
                'groupId' => $identifier->groupId,
                'metadata' => $identifier->metadata,
            ],
            $identifiers,
        );

        $translations = $this->apiClient->getTranslations($accessToken, $locales, $items);

        return array_map(
            fn (array $translation) => $this->contentItemMapper->mapArrayToContentItem($translation),
            $translations,
        );
    }
}
