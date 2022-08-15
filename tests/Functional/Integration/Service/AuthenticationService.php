<?php

namespace App\Tests\Functional\Integration\Service;

use App\Interfaces\Service\AuthenticationServiceInterface;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function auth(string $key): string
    {
        return $key;
    }

    public function refresh(string $refreshKey): string
    {
        return $this->auth($refreshKey);
    }
}
