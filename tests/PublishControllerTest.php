<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublishControllerTest extends AbstractApiTestCase
{
    public function testPublish(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/publish',
            [
                "items" => [
                    [
                        "uniqueId" => "post:1:title",
                        "groupId" => "post:1",
                        "metadata" => [
                            "contentType" => "post",
                            "field" => "title"
                        ],
                        "translations" => [
                            "ge" => "Hallo Welt!"
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
        $this->assertEquals('{"code":"200","message":"Content successfully updated"}', $response->getContent());
    }

    public function testPublishNotAuthorised(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/publish',
            [
                "items" => [
                    [
                        "uniqueId" => "post:1:title",
                        "groupId" => "post:1",
                        "metadata" => [
                            "contentType" => "post",
                            "field" => "title"
                        ],
                        "translations" => [
                            "ge" => "Hallo Welt!"
                        ]
                    ]
                ]
            ]
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('{"code":403,"message":"Not authorised"}', $response->getContent());
    }

    public function testPublishEmptyRequest(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/publish',
            [],
            ['HTTP_x-api-token' => 'token']
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
