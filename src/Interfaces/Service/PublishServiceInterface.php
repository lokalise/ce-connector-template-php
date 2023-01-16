<?php

namespace App\Interfaces\Service;

use App\DTO\TranslationItem;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;

interface PublishServiceInterface
{
    /**
     * @param array<int, TranslationItem> $translations
     *
     * @return array<int, TranslationItem>
     */
    public function publishContent(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $translations,
        string $defaultLocale,
    ): array;
}
