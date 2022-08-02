<?php

namespace App\Tests\Integration\DataProvider;

abstract class CacheDataProvider extends UniqueItemIdentifierDataProvider
{
    private static function getCacheParameters(): array
    {
        return [
            [self::getItemsData()],
        ];
    }

    public static function cacheResponseProvider(): array
    {
        return self::getCacheParameters();
    }

    public static function cacheRequestProvider(): array
    {
        return self::getCacheParameters();
    }

    public static function cacheRequestAndResponseParametersProvider(): array
    {
        $request = self::getItemsData();

        $response = self::getItemsData([
            "fields" => self::METADATA,
        ]);

        return [
            [$request, $response],
        ];
    }
}
