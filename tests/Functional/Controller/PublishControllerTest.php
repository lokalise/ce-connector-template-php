<?php

namespace App\Tests\Functional\Controller;

use App\Enum\ErrorCodeEnum;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublishControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishProvider
     *
     * @throws JsonException
     */
    public function testPublish(array $request, array $expectedResponse): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/publish',
            parameters: $request,
            server: static::getTestHeaders(),
            expectedResponse: $expectedResponse,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishRequestWithoutAuthHeaderProvider
     *
     * @throws JsonException
     */
    public function testPublishNotAuthorised(array $request, array $response): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/publish',
            $request,
            static::getTestConnectorConfigHeader(),
            $response,
            Response::HTTP_UNAUTHORIZED,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishWithEmptyRequestProvider
     *
     * @throws JsonException
     */
    public function testPublishEmptyRequest(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/publish',
            server: static::getTestHeaders(),
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }
}
