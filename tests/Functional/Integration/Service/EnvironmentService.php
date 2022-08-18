<?php

namespace App\Tests\Functional\Integration\Service;

use App\DTO\EnvItem;
use App\DTO\LocaleItem;
use App\Integration\DTO\CacheItemStructure;
use App\Interfaces\Service\EnvironmentServiceInterface;
use App\Tests\Functional\DataProvider\EnvironmentDataProvider;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function getEnvironments(string $accessToken): EnvItem
    {
        return new EnvItem(
            EnvironmentDataProvider::LOCALE_CODE,
            [
                new LocaleItem(EnvironmentDataProvider::LOCALE_NAME, EnvironmentDataProvider::LOCALE_CODE)
            ],
            new CacheItemStructure(),
        );
    }
}
