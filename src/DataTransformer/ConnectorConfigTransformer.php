<?php

namespace App\DataTransformer;

use App\Integration\DTO\ConnectorConfig;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * трансформер декодирует конфигурационный хедер и создает объект типа ConnectorConfig
 */
class ConnectorConfigTransformer
{
    public function __construct(
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function transform(string $encodedConnectorConfig): ConnectorConfig
    {
        $connectorConfigJson = base64_decode($encodedConnectorConfig, true);

        return $this->serializer->deserialize(
            $connectorConfigJson,
            ConnectorConfig::class,
            JsonEncoder::FORMAT,
        );
    }
}
