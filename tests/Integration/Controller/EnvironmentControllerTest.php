<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnvironmentControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider App\Tests\Integration\DataProvider\EnvironmentDataProvider::environmentResponseProvider
     */
    public function testEnv(array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/env',
            [],
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    public function testEnvNotAuthorised(): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_GET,
            '/env'
        );
    }
}
