<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationControllerTest extends AbstractApiTestCase
{
    public function testTranslate(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/translate',
            [
                "locales" => [
                    "en",
                    "en_US",
                    "ru"
                ],
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
        $this->assertEquals('{"items":[{"translations":{"en":"en","en_US":"en_US","ru":"ru"},"uniqueId":"post:1:title","groupId":"post:1","metadata":{"contentType":"post","field":"title"}}]}', $response->getContent());
    }
}
