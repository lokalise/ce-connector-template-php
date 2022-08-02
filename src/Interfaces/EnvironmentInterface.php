<?php

namespace App\Interfaces;

use App\DTO\EnvItem;

interface EnvironmentInterface
{
    /**
     * @return array<int, EnvItem>|null
     */
    public function getEnv(string $accessToken): ?array;
}
