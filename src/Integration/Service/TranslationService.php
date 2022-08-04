<?php

namespace App\Integration\Service;

use App\DTO\TranslationItem;
use App\DTO\Identifier;
use App\Interfaces\ApiClientInterface;
use App\Interfaces\Mapper\TranslationItemMapperInterface;
use App\Interfaces\Mapper\IdentifierMapperInterface;
use App\Interfaces\Service\TranslationServiceInterface;

class TranslationService implements TranslationServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
        private readonly TranslationItemMapperInterface $translationItemMapper,
        private readonly IdentifierMapperInterface $identifierMapper,
    ) {
    }

    /**
     * @param array<int, string> $locales
     * @param array<int, Identifier> $identifiers
     *
     * @return array<int, TranslationItem>
     */
    public function getTranslations(string $accessToken, array $locales, array $identifiers): array
    {
        $items = array_map(
            fn (Identifier $identifier) => $this->identifierMapper->mapIdentifierToArray($identifier),
            $identifiers,
        );

        $translations = $this->apiClient->getTranslations($accessToken, $locales, $items);

        return array_map(
            fn (array $translation) => $this->translationItemMapper->mapArrayToTranslationItem($translation),
            $translations,
        );
    }
}
