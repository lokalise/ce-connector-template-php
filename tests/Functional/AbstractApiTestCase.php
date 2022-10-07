<?php

namespace App\Tests\Functional;

use App\Tests\Constraint\IsResponse;
use App\Tests\Functional\DataProvider\AuthenticationDataProvider;
use Exception;
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
            return static::getContainer()->get('test.client');
        } catch (Exception|ServiceNotFoundException) {
            if (class_exists(KernelBrowser::class)) {
                throw new LogicException(
                    'You cannot create the client used in functional tests if the "framework.test" config is not set to true.'
                );
            }

            throw new LogicException(
                'You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit".'
            );
        }
    }

    public static function assertRequest(
        string $method,
        string $uri,
        array $parameters = [],
        array $server = [],
        array $expectedResponse = [],
        int $expectedStatusCode = Response::HTTP_OK,
    ): void {
        $client = static::createClient();

        $client->jsonRequest($method, $uri, $parameters, $server);

        self::assertThat(
            $client->getResponse(),
            new IsResponse(
                $expectedStatusCode,
                $expectedResponse,
            )
        );
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

    /**
     * @return array{
     *     HTTP_ce-config: string,
     *     HTTP_ce-auth: string,
     * }
     *
     * @throws JsonException
     */
    public static function getTestHeaders(): array
    {
        return array_merge(
            static::getTestConnectorConfigHeader(),
            static::getTestTokenHeader(),
        );
    }
}
