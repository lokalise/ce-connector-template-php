<?php

namespace App\Interfaces\Service;

use App\DTO\EnvItem;
use App\Exception\AccessDeniedException;

interface EnvironmentServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function getEnvironments(string $accessToken): EnvItem;
}
