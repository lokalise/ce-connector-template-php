<?php

namespace App\Integration\Service;

use App\DTO\EnvItem;
use App\Integration\ApiClient;
use App\Interfaces\Mapper\EnvItemMapperInterface;
use App\Interfaces\Service\EnvironmentServiceInterface;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function __construct(
        private readonly ApiClient $apiClient,
        private readonly EnvItemMapperInterface $envItemMapper,
    ) {
    }

    public function getEnvironments(string $accessToken): EnvItem
    {
        $environments = $this->apiClient->getEnvironments($accessToken);

        return $this->envItemMapper->mapArrayToEnvItem($environments);
    }
}
