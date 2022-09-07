<?php

namespace App\Interfaces\Service;

use App\DTO\EnvItem;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredentials;

interface EnvironmentServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function getEnvironments(AuthCredentials $credentials): EnvItem;
}
