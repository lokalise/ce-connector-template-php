<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

class CacheControllerTest extends AbstractApiTestCase
{
    public function testCache(): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/cache',
            [],
            $this->getCacheRequestAndResponseParameters(),
            static::getTestTokenHeader()
        );
    }

    public function testCacheNotAuthorised(): void
    {
        static::checkNotAuthorisedRequest(
            Request::METHOD_GET,
            '/cache'
        );
    }

    public function testCacheItems(): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/cache/items',
            $this->getCacheRequestAndResponseParameters(),
            [
                "items" => [
                    [
                        "groupId" => "post:1",
                        "uniqueId" => "post:1:title",
                        "metadata" => [
                            "contentType" => "post",
                            "field" => "title",
                        ],
                        "fields" => [
                            "contentType" => "post",
                            "field" => "title",
                        ],
                    ],
                ],
            ],
            static::getTestTokenHeader()
        );
    }

    public function testCacheItemsNotAuthorised(): void
    {
        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/cache/items',
            $this->getCacheRequestAndResponseParameters()
        );
    }

    public function testCacheItemsEmptyRequest(): void
    {
        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/cache/items',
            static::getTestTokenHeader()
        );
    }

    private function getCacheRequestAndResponseParameters(): array
    {
        return [
            "items" => [
                [
                    "groupId" => "post:1",
                    "uniqueId" => "post:1:title",
                    "metadata" => [
                        "contentType" => "post",
                        "field" => "title",
                    ],
                ],
            ],
        ];
    }
}
