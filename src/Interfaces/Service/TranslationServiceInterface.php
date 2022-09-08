<?php

namespace App\Interfaces\Service;

use App\DTO\Identifier;
use App\DTO\TranslationItem;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;

interface TranslationServiceInterface
{
    /**
     * @param array<int, string> $locales
     * @param array<int, Identifier> $identifiers
     *
     * @return array<int, TranslationItem>
     *
     * @throws AccessDeniedException
     */
    public function getTranslations(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $locales,
        array $identifiers,
        string $defaultLocale
    ): array;
}
