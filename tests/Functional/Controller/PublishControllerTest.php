<?php

namespace App\Tests\Functional\Controller;

use App\Exception\BadRequestHttpException;
use App\Exception\UnauthorizedHttpException;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;

class PublishControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishProvider
     *
     * @throws JsonException
     */
    public function testPublish(array $parameters, array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/v2/publish',
            $parameters,
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishRequestProvider
     *
     * @throws JsonException
     */
    public function testPublishNotAuthorised(array $parameters): void
    {
        $this->expectException(UnauthorizedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/v2/publish',
            $parameters
        );
    }

    /**
     * @throws JsonException
     */
    public function testPublishEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/v2/publish',
            static::getTestTokenHeader()
        );
    }
}
