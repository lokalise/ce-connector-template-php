<?php

namespace App\Integration\Service;

use App\DTO\EnvItem;
use App\Interfaces\ApiClientInterface;
use App\Interfaces\Mapper\EnvItemMapperInterface;
use App\Interfaces\Service\EnvironmentServiceInterface;

class EnvironmentService implements EnvironmentServiceInterface
{
    public function __construct(
        private readonly ApiClientInterface $apiClient,
        private readonly EnvItemMapperInterface $envItemMapper,
    ) {
    }

    /**
     * @return array<int, EnvItem>
     */
    public function getEnvironments(string $accessToken): array
    {
        $environments = $this->apiClient->getEnvironments($accessToken);

        return array_map(
            fn (array $environment) => $this->envItemMapper->mapArrayToEnvItem($environment),
            $environments,
        );
    }
}
