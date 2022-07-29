<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EnvironmentControllerTest extends AbstractApiTestCase
{
    public function testEnv(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_GET,
            '/env',
            [],
            ['HTTP_x-api-token' => 'token']
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('{"items":[{"defaultLocale":"de","locales":[{"name":"German","code":"de"}],"cacheItemStructure":{"title":"Title"}}]}', $response->getContent());
    }

    public function testEnvNotAuthorised(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_GET,
            '/env'
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('{"code":403,"message":"Not authorised"}', $response->getContent());
    }
}
