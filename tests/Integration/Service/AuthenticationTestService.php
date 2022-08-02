<?php

namespace App\Tests\Integration\Service;

use App\Interfaces\AuthenticationInterface;

class AuthenticationTestService implements AuthenticationInterface
{
    const KEY = 'irure dolor in';
    const REFRESH_KEY = 'dolor Excepteur exercitation';

    public function validate(string $key): ?string
    {
        return self::KEY;
    }

    public function refresh(string $refreshKey): ?string
    {
        return self::REFRESH_KEY;
    }
}
