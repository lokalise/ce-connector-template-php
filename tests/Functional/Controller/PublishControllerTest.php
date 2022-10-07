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
     * @dataProvider \App\Tests\Functional\DataProvider\PublishDataProvider::publishRequestProvider
     *
     * @throws JsonException
     */
    public function testPublishNotAuthorised(array $request): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/publish',
            $request,
            static::getTestConnectorConfigHeader(),
            [
                'statusCode' => Response::HTTP_UNAUTHORIZED,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::AUTH_FAILED_ERROR->value,
                    'details' => [
                        'error' => 'Invalid api key',
                    ],
                    'message' => 'Authorization failed',
                ],
            ],
            Response::HTTP_UNAUTHORIZED,
        );
    }

    /**
     * @throws JsonException
     */
    public function testPublishEmptyRequest(): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/publish',
            server: static::getTestHeaders(),
            expectedResponse: [
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR->value,
                    'details' => [
                        'errors' => [
                            [
                                'defaultLocale' => ['This value should not be blank.'],
                                'items' => ['This value should not be blank.'],
                            ],
                        ],
                    ],
                    'message' => 'Bad request',
                ],
            ],
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }
}
