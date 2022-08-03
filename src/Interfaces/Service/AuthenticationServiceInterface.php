<?php

namespace App\Interfaces\Service;

use App\Exception\AccessDeniedException;

interface AuthenticationServiceInterface
{
    /**
     * @throws AccessDeniedException
     */
    public function auth(string $key): string;

    /**
     * @throws AccessDeniedException
     */
    public function refresh(string $refreshKey): string;
}
