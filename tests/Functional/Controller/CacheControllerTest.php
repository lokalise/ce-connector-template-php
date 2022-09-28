<?php

namespace App\Tests\Functional\Controller;

use App\Exception\BadRequestHttpException;
use App\Exception\UnauthorizedHttpException;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;

class CacheControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheResponseProvider
     *
     * @throws JsonException
     */
    public function testCache(array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/v2/cache',
            [],
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    /**
     * @throws JsonException
     */
    public function testCacheNotAuthorised(): void
    {
        $this->expectException(UnauthorizedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_GET,
            '/v2/cache'
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsProvider
     *
     * @throws JsonException
     */
    public function testCacheItems(array $parameters, array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/v2/cache/items',
            $parameters,
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsRequestProvider
     *
     * @throws JsonException
     */
    public function testCacheItemsNotAuthorised(array $parameters): void
    {
        $this->expectException(UnauthorizedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/v2/cache/items',
            $parameters
        );
    }

    /**
     * @throws JsonException
     */
    public function testCacheItemsEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/v2/cache/items',
            static::getTestTokenHeader()
        );
    }
}
