<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationControllerTest extends AbstractApiTestCase
{
    public function testAuth(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/auth',
            ["key" => 'irure dolor in']
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('{"key":"irure dolor in"}', $response->getContent());
    }

    public function testRefresh(): void
    {
        self::bootKernel();

        $client = static::createClient();

        $client->jsonRequest(
            Request::METHOD_POST,
            '/auth/refresh',
            ["refreshKey" => 'dolor Excepteur exercitation']
        );

        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertNotEmpty($response->getContent());
        $this->assertEquals('{"key":"dolor Excepteur exercitation"}', $response->getContent());
    }
}
