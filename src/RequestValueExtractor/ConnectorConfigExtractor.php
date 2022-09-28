<?php

namespace App\RequestValueExtractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * Извлекает конфигурационный хедер из реквеста
 */
class ConnectorConfigExtractor implements RequestValueExtractorInterface
{
    public const CONNECTOR_CONFIG_HEADER = 'CE-Config';

    public function extract(Request $request): ?string
    {
        $connectorConfig = strtolower(self::CONNECTOR_CONFIG_HEADER);

        return $request->headers->get($connectorConfig);
    }
}
