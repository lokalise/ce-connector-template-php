<?php

namespace App\Tests\Integration;

use LogicException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractApiTestCase extends KernelTestCase
{
    protected static function createClient(): KernelBrowser
    {
        try {
            /** @var KernelBrowser $client */
            $client = static::getContainer()->get('test.client');
        } catch (ServiceNotFoundException) {
            if (class_exists(KernelBrowser::class)) {
                throw new LogicException(
                    'You cannot create the client used in functional tests if the "framework.test" config is not set to true.'
                );
            }

            throw new LogicException(
                'You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit".'
            );
        }

        return $client;
    }

    public static function checkRequest(
        string $method,
        string $uri,
        array $parameters,
        array $expectedResponse,
        array $server = []
    ): void {
        $client = static::createClient();

        $client->jsonRequest(
            $method,
            $uri,
            $parameters,
            $server
        );

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('Content-Type'));
        self::assertNotEmpty($response->getContent());
        self::assertEquals(
            $expectedResponse,
            json_decode($response->getContent(), true)
        );
    }

    public static function checkNotAuthorisedRequest(string $method, string $uri, array $parameters = []): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            $method,
            $uri,
            $parameters
        );

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('Content-Type'));
        self::assertNotEmpty($response->getContent());
        self::assertEquals(
            [
                'code' => 403,
                'message' => 'Not authorised',
            ],
            json_decode($response->getContent(), true)
        );
    }

    public static function checkEmptyRequest(string $method, string $uri, array $server = []): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            $method,
            $uri,
            [],
            $server
        );

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public static function getTestTokenHeader(): array
    {
        return [
            'HTTP_x-api-token' => 'token',
        ];
    }
}