<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class EnvironmentControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\EnvironmentDataProvider::environmentResponseProvider
     *
     * @throws JsonException
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

    /**
     * @throws JsonException
     */
    public function testEnvNotAuthorised(): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_GET,
            '/env'
        );
    }
}
