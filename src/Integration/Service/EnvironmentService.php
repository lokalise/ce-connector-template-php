<?php

namespace App\Integration\Service;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Integration\DTO\AuthCredentials;
use App\Integration\DTO\CacheItemStructure;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\Service\EnvironmentServiceInterface;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function getEnvironments(AuthCredentials $credentials, ConnectorConfig $connectorConfig): EnvItem
    {
        return new EnvItem(
            'de',
            [
                new LocaleItem('German', 'de'),
            ],
            new CacheItemStructure(),
        );
    }
}
