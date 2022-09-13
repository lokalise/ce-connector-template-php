<?php

namespace App\Interfaces\Service;

use App\DTO\Identifier;
use App\DTO\IdentifiersList;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;

interface CacheServiceInterface
{
    /**
     * @return array<int, Identifier>
     */
    public function getCache(AuthCredentials $credentials, ConnectorConfig $connectorConfig): array;

    /**
     * @param array<int, Identifier> $identifiers
     */
    public function getCacheItems(
        AuthCredentials $credentials,
        ConnectorConfig $connectorConfig,
        array $identifiers,
    ): IdentifiersList;
}
