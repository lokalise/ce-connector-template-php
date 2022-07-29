<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControllerTest extends AbstractApiTestCase
{
    public function testCache(): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_GET,
            '/cache',
            [],
            [
                'HTTP_x-api-token' => 'token',
            ]
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals(
            [
                "items" => [
                    [
                        "uniqueId" => "post:1:title",
                        "groupId" => "post:1",
                        "metadata" => [
                            "contentType" => "post",
                            "field" => "title",
                        ],
                    ],
                ],
            ],
            json_decode($response->getContent(), true)
        );
    }

    public function testCacheNotAuthorised(): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_GET,
            '/cache'
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('{"code":403,"message":"Not authorised"}', $response->getContent());
    }

    public function testCacheItems(): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/cache/items',
            [
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
            ],
            [
                'HTTP_x-api-token' => 'token',
            ]
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals(
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
            json_decode($response->getContent(), true)
        );
    }

    public function testCacheItemsNotAuthorised(): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/cache/items',
            [
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
            ]
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('{"code":403,"message":"Not authorised"}', $response->getContent());
    }

    public function testCacheItemsEmptyRequest(): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/cache/items',
            [],
            [
                'HTTP_x-api-token' => 'token',
            ]
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
