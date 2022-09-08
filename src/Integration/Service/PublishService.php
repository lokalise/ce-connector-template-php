<?php

namespace App\Integration\Service;

use App\DTO\TranslationItem;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Service\PublishServiceInterface;

class PublishService implements PublishServiceInterface
{
    /**
     * @param array<int, TranslationItem> $translations
     */
    public function publishContent(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $translations,
        string $defaultLocale,
    ): void {
    }
}
