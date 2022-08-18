<?php

namespace App\Interfaces\Service;

use App\DTO\EnvItem;
use App\Exception\AccessDeniedException;
use App\Integration\DTO\AuthCredential;

interface EnvironmentServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function getEnvironments(AuthCredential $authCredential): EnvItem;
}
