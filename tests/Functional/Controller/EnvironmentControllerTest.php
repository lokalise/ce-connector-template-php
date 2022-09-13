<?php

namespace App\Tests\Functional\Controller;

use App\Exception\UnauthorizedHttpException;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;

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
            '/v2/env',
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
        $this->expectException(UnauthorizedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_GET,
            '/v2/env'
        );
    }
}
