<?php

namespace App\Tests\Functional\DataProvider;

final class AuthenticationDataProvider
{
    public const KEY = '';

    public const REFRESH_KEY = '';

    public static function authProvider(): array
    {
        return [
            [self::KEY],
        ];
    }

    public static function refreshProvider(): array
    {
        return [
            [self::REFRESH_KEY],
        ];
    }
}