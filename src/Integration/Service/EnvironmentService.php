<?php

namespace App\Integration\Service;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Integration\DTO\AuthCredential;
use App\Integration\DTO\CacheItemStructure;
use App\Interfaces\Service\EnvironmentServiceInterface;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function getEnvironments(AuthCredential $authCredential): EnvItem
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
