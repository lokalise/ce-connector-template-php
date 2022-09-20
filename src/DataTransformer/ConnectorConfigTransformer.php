<?php

namespace App\DataTransformer;

use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\DataTransformer\ConnectorConfigTransformerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ConnectorConfigTransformer implements ConnectorConfigTransformerInterface
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

    public function reverseTransform(ConnectorConfig $connectorConfig): string
    {
        $connectorConfigJson = $this->serializer->serialize($connectorConfig, JsonEncoder::FORMAT);

        return base64_encode($connectorConfigJson);
    }
}
