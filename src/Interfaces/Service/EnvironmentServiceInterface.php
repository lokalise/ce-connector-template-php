<?php

namespace App\Interfaces\Service;

use App\DTO\EnvItem;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AccessCredentials;

interface EnvironmentServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function getEnvironments(AccessCredentials $credentials): EnvItem;
}
