<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EnvironmentControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\EnvironmentDataProvider::environmentResponseProvider
     *
     * @throws \JsonException
     */
    public function testEnv(array $expectedResponse): void
    {
        static::assertRequest(
            method: Request::METHOD_GET,
            uri: '/v2/env',
            server: static::getTestHeaders(),
            expectedResponse: $expectedResponse,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\EnvironmentDataProvider::environmentWithoutAuthHeaderProvider
     *
     * @throws \JsonException
     */
    public function testEnvNotAuthorised(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_GET,
            uri: '/v2/env',
            server: static::getTestConnectorConfigHeader(),
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_UNAUTHORIZED,
        );
    }
}
