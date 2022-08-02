<?php

namespace App\Interfaces;

interface AuthenticationInterface
{
    public function validate(string $key): ?string;

    public function refresh(string $refreshKey): ?string;
}
