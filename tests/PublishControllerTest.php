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
}
