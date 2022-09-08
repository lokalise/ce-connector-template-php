<?php

namespace App\Interfaces\Service;

use App\DTO\TranslationItem;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;

interface PublishServiceInterface
{
    /**
     * @param array<int, TranslationItem> $translations
     *
     * @throws AccessDeniedException
     */
    public function publishContent(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $translations,
        string $defaultLocale,
    ): void;
}
