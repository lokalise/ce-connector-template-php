<?php

namespace App\Tests\Functional;

use App\Enum\AuthTypeEnum;
use App\Tests\Functional\DataProvider\AuthenticationDataProvider;
use JsonException;
use LogicException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
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

    /**
     * @throws JsonException
     */
    public static function checkRequest(
        string $method,
        string $uri,
        array $parameters,
        array|string $expectedResponse,
        array $server = []
    ): array|string {
        $client = static::createClient();

        $client->jsonRequest(
            $method,
            $uri,
            $parameters,
            array_merge($server, static::getTestConnectorConfigHeader()),
        );

        $response = $client->getResponse();
        $decodedResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('Content-Type'));
        self::assertNotEmpty($response->getContent());
        self::assertEquals(
            $expectedResponse,
            $decodedResponse
        );

        return $decodedResponse;
    }

    /**
     * @throws JsonException
     */
    public static function checkNotAuthorisedRequest(
        string $method,
        string $uri,
        array $parameters = [],
        array $server = []
    ): array {
        $client = static::createClient();

        $client->catchExceptions(false);

        $client->jsonRequest(
            $method,
            $uri,
            $parameters,
            array_merge(static::getTestConnectorConfigHeader(), $server),
        );

        $response = $client->getResponse();
        $decodedResponse = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertSame(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        self::assertSame('application/json', $response->headers->get('Content-Type'));
        self::assertNotEmpty($response->getContent());
        self::assertEquals(
            [
                'code' => 403,
                'message' => 'Not authorised',
            ],
            $decodedResponse
        );

        return $decodedResponse;
    }

    /**
     * @throws JsonException
     */
    public static function checkEmptyRequest(string $method, string $uri, array $server = []): array
    {
        $client = static::createClient();

        $client->catchExceptions(false);

        $client->jsonRequest(
            $method,
            $uri,
            [],
            array_merge(static::getTestConnectorConfigHeader(), $server),
        );

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());

        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array{
     *     HTTP_ce-auth: string,
     * }
     *
     * @throws JsonException
     */
    public static function getTestTokenHeader(): array
    {
        return [
            'HTTP_ce-auth' => AuthenticationDataProvider::encodedApiKey(),
        ];
    }

    /**
     * @return array{
     *     HTTP_ce-config: string,
     * }
     *
     * @throws JsonException
     */
    public static function getTestConnectorConfigHeader(): array
    {
        return [
            'HTTP_ce-config' => AuthenticationDataProvider::encodedConnectorConfig(),
        ];
    }
}
