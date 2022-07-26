<?php

namespace App\Integration;

use App\Interfaces\AuthenticationInterface;

class AuthenticationService implements AuthenticationInterface
{
    public function validate(string $key): ?string
    {
        return $key;
    }

    public function refresh(string $refreshKey): ?string
    {
        return $refreshKey;
    }
}