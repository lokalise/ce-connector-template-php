<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class CacheControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheResponseProvider
     */
    public function testCache(array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/cache',
            [],
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    public function testCacheNotAuthorised(): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_GET,
            '/cache'
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsProvider
     */
    public function testCacheItems(array $parameters, array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/cache/items',
            $parameters,
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\CacheDataProvider::cacheItemsRequestProvider
     */
    public function testCacheItemsNotAuthorised(array $parameters): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/cache/items',
            $parameters
        );
    }

    public function testCacheItemsEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/cache/items',
            static::getTestTokenHeader()
        );
    }
}
