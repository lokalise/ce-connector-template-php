<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use App\Tests\Integration\Service\EnvironmentTestService;
use Symfony\Component\HttpFoundation\Request;

class EnvironmentControllerTest extends AbstractApiTestCase
{
    public function testEnv(): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/env',
            [],
            [
                "items" => [
                    [
                        "defaultLocale" => EnvironmentTestService::LOCALE_CODE,
                        "locales" => [
                            [
                                "name" => EnvironmentTestService::LOCALE_NAME,
                                "code" => EnvironmentTestService::LOCALE_CODE,
                            ],
                        ],
                        "cacheItemStructure" => EnvironmentTestService::CACHE_ITEM_STRUCTURE,
                    ],
                ],
            ],
            static::getTestTokenHeader()
        );
    }

    public function testEnvNotAuthorised(): void
    {
        static::checkNotAuthorisedRequest(
            Request::METHOD_GET,
            '/env'
        );
    }
}
