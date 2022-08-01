<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

class EnvironmentControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider App\Tests\Integration\DataProvider\EnvironmentDataProvider::environmentResponseProvider
     */
    public function testEnv(array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/env',
            [],
            $expectedResponse,
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
