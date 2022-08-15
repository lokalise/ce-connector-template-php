<?php

namespace App\Tests\Functional\Integration\Service;

use App\DTO\EnvItem;
use App\Interfaces\Mapper\EnvItemMapperInterface;
use App\Interfaces\Service\EnvironmentServiceInterface;
use App\Tests\Functional\DataProvider\EnvironmentDataProvider;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function __construct(
        private readonly EnvItemMapperInterface $envItemMapper,
    ) {
    }

    public function getEnvironments(string $accessToken): EnvItem
    {
        $environments = EnvironmentDataProvider::ENVIRONMENTS;
        $environments['languages'] = $environments['locales'];

        return $this->envItemMapper->mapArrayToEnvItem($environments);
    }
}
