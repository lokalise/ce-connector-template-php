<?php

namespace App\Integration;

use App\DTO\EnvItem;
use App\Interfaces\EnvironmentInterface;

class EnvironmentService implements EnvironmentInterface
{
    /**
     * @return array<int, EnvItem>|null
     */
    public function getEnv(string $accessToken): ?array
    {
        return [];
    }
}
