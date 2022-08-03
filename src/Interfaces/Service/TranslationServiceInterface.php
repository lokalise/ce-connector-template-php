<?php

namespace App\Interfaces\Service;

use App\DTO\ContentItem;
use App\DTO\UniqueItemIdentifier;
use App\Exception\AccessDeniedException;

interface TranslationServiceInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, UniqueItemIdentifier> $identifiers
     *
     * @return array<int, ContentItem>
     *
     * @throws AccessDeniedException
     */
    public function getTranslations(string $accessToken, array $locales, array $identifiers): array;
}
