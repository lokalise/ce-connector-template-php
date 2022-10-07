<?php

namespace App\Tests\Functional\Controller;

use App\Enum\ErrorCodeEnum;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EnvironmentControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\EnvironmentDataProvider::environmentResponseProvider
     *
     * @throws JsonException
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
     * @throws JsonException
     */
    public function testEnvNotAuthorised(): void
    {
        static::assertRequest(
            method: Request::METHOD_GET,
            uri: '/v2/env',
            server: static::getTestConnectorConfigHeader(),
            expectedResponse: [
                'statusCode' => Response::HTTP_UNAUTHORIZED,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::AUTH_FAILED_ERROR->value,
                    'details' => [
                        'error' => 'Invalid api key',
                    ],
                    'message' => 'Authorization failed',
                ],
            ],
            expectedStatusCode: Response::HTTP_UNAUTHORIZED,
        );
    }
}
