<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PublishControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishProvider
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
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishRequestProvider
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
