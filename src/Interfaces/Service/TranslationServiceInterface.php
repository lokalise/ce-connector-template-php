<?php

namespace App\Interfaces\Service;

use App\DTO\Identifier;
use App\DTO\IdentifiersList;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;

interface TranslationServiceInterface
{
    /**
     * @param array<int, string>     $locales
     * @param array<int, Identifier> $identifiers
     */
    public function getTranslations(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $locales,
        array $identifiers,
        string $defaultLocale
    ): IdentifiersList;
}
