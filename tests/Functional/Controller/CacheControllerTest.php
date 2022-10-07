<?php

namespace App\Tests\Functional\Controller;

use App\Enum\ErrorCodeEnum;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheResponseProvider
     *
     * @throws JsonException
     */
    public function testCache(array $expectedResponse): void
    {
        static::assertRequest(
            method: Request::METHOD_GET,
            uri: '/v2/cache',
            server: static::getTestHeaders(),
            expectedResponse: $expectedResponse,
        );
    }

    /**
     * @throws JsonException
     */
    public function testCacheNotAuthorised(): void
    {
        static::assertRequest(
            method: Request::METHOD_GET,
            uri: '/v2/cache',
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

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsProvider
     *
     * @throws JsonException
     */
    public function testCacheItems(array $request, array $expectedResponse): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/cache/items',
            $request,
            static::getTestHeaders(),
            $expectedResponse,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::invalidCacheItemsProvider()
     *
     * @throws JsonException
     */
    public function testCacheItemsWithInvalidUniqueId(array $request, array $expectedResponse): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/cache/items',
            $request,
            static::getTestHeaders(),
            $expectedResponse,
            Response::HTTP_MULTI_STATUS,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsRequestProvider
     *
     * @throws JsonException
     */
    public function testCacheItemsNotAuthorised(array $request): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/cache/items',
            $request,
            static::getTestConnectorConfigHeader(),
            [
                'statusCode' => Response::HTTP_UNAUTHORIZED,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::AUTH_FAILED_ERROR->value,
                    'details' => [
                        'error' => 'Invalid api key',
                    ],
                    'message' => 'Authorization failed',
                ],
            ],
            Response::HTTP_UNAUTHORIZED,
        );
    }

    /**
     * @throws JsonException
     */
    public function testCacheItemsEmptyRequest(): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/cache/items',
            server: static::getTestHeaders(),
            expectedResponse: [
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR->value,
                    'details' => [
                        'errors' => [[
                            'items' => ['This value should not be blank.'],
                        ]],
                    ],
                    'message' => 'Bad request',
                ],
            ],
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }
}
