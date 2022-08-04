<?php

namespace App\Tests\Functional\DataProvider;

final class AuthenticationDataProvider
{
    public const KEY = 'irure dolor in';

    public const REFRESH_KEY = 'dolor Excepteur exercitation';

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
