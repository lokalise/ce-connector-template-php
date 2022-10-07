<?php

namespace App\Tests\Functional\Controller;

use App\Enum\ErrorCodeEnum;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslationControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\TranslationDataProvider::translationProvider
     *
     * @throws JsonException
     */
    public function testTranslate(array $request, array $expectedResponse): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/translate',
            $request,
            static::getTestHeaders(),
            $expectedResponse,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\TranslationDataProvider::translationRequestProvider
     *
     * @throws JsonException
     */
    public function testTranslateNotAuthorised(array $request): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/translate',
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
    public function testTranslateEmptyRequest(): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/translate',
            server: static::getTestHeaders(),
            expectedResponse: [
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'payload' => [
                    'errorCode' => ErrorCodeEnum::UNKNOWN_ERROR->value,
                    'details' => [
                        'errors' => [
                            [
                                'defaultLocale' => ['This value should not be blank.'],
                                'locales' => ['This value should not be blank.'],
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
