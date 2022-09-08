<?php

namespace App\RequestValueExtractor;

use App\Exception\ExtractorNotExistException;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\ConnectorConfig;

final class RequestValueExtractorFactory
{
    public function __construct(
        private readonly ApiKeyExtractor $apiKeyExtractor,
        private readonly ConnectorConfigExtractor $connectorConfigExtractor,
    ) {
    }

    /**
     * @throws ExtractorNotExistException
     */
    public function factory(string $dtoClass): RequestValueExtractorInterface
    {
        return match ($dtoClass) {
            AuthCredentials::class => $this->apiKeyExtractor,
            ConnectorConfig::class => $this->connectorConfigExtractor,
            default => throw new ExtractorNotExistException(),
        };
    }
}
