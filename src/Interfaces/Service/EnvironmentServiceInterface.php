<?php

namespace App\Interfaces\Service;

use App\DTO\EnvItem;
use App\Exception\AccessDeniedException;

interface EnvironmentServiceInterface
{
    /**
     * @return array<int, EnvItem>
     *
     * @throws AccessDeniedException
     */
    public function getEnvironments(string $accessToken): array;
}
