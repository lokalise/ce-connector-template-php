<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;

class CacheControllerTest extends AbstractApiTestCase
{
    public function testCache(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_GET,
            '/cache',
            [],
            ['HTTP_x-api-token' => 'token']
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals(
            '{"items":[{"uniqueId":"post:1:title","groupId":"post:1","metadata":{"contentType":"post","field":"title"}}]}',
            $response->getContent()
        );
    }

    public function testCacheItems(): void
    {
        self::bootKernel();

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
                            "field" => "title"
                        ]
                    ]
                ]
            ],
            ['HTTP_x-api-token' => 'token']
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals(
            '{"items":[{"fields":{"contentType":"post","field":"title"},"uniqueId":"post:1:title","groupId":"post:1","metadata":{"contentType":"post","field":"title"}}]}',
            $response->getContent()
        );
    }
}