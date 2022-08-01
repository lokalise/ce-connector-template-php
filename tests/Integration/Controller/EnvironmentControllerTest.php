<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
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
                        "defaultLocale" => "de",
                        "locales" => [
                            [
                                "name" => "German",
                                "code" => "de",
                            ],
                        ],
                        "cacheItemStructure" => [
                            "title" => "Title",
                        ],
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
