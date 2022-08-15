<?php

namespace App\Integration\Service;

use App\DTO\EnvItem;
use App\Interfaces\Mapper\EnvItemMapperInterface;
use App\Interfaces\Service\EnvironmentServiceInterface;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function __construct(
        private readonly EnvItemMapperInterface $envItemMapper,
    ) {
    }

    public function getEnvironments(string $accessToken): EnvItem
    {
        return $this->envItemMapper->mapArrayToEnvItem([
            'defaultLocale' => 'de',
            'languages' => [
                [
                    'code' => 'de',
                    'name' => 'German',
                ],
            ],
            'cacheItemStructure' => [
                'id' => 'ID',
            ],
        ]);
    }
}
