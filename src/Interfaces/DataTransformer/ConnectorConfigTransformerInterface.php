<?php

namespace App\Interfaces\DataTransformer;

use App\Integration\DTO\ConnectorConfig;

interface ConnectorConfigTransformerInterface
{
    public function transform(string $encodedConnectorConfig): ConnectorConfig;

    public function reverseTransform(ConnectorConfig $connectorConfig): string;
}
