<?php

namespace App\Integration\Service;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Integration\DTO\AccessCredentials;
use App\Integration\DTO\CacheItemStructure;
use App\Interfaces\Service\EnvironmentServiceInterface;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function getEnvironments(AccessCredentials $credentials): EnvItem
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
