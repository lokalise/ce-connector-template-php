<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PublishControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider App\Tests\Integration\DataProvider\PublishDataProvider::publishRequestParametersProvider
     */
    public function testPublish(array $parameters, array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/publish',
            $parameters,
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    /**
     * @dataProvider App\Tests\Integration\DataProvider\PublishDataProvider::publishRequestParametersProvider
     */
    public function testPublishNotAuthorised(array $parameters): void
    {
        $this->expectException(AccessDeniedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/publish',
            $parameters
        );
    }

    public function testPublishEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/publish',
            static::getTestTokenHeader()
        );
    }
}
