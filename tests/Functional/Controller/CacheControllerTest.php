<?php

namespace App\Tests\Functional\Controller;

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
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheWithoutAuthHeaderProvider
     *
     * @throws JsonException
     */
    public function testCacheNotAuthorised(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_GET,
            uri: '/v2/cache',
            server: static::getTestConnectorConfigHeader(),
            expectedResponse: $response,
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
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsRequestWithoutAuthHeaderProvider
     *
     * @throws JsonException
     */
    public function testCacheItemsNotAuthorised(array $request, array $response): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/cache/items',
            $request,
            static::getTestConnectorConfigHeader(),
            $response,
            Response::HTTP_UNAUTHORIZED,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsWithEmptyRequestProvider
     *
     * @throws JsonException
     */
    public function testCacheItemsEmptyRequest(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/cache/items',
            server: static::getTestHeaders(),
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }
}
