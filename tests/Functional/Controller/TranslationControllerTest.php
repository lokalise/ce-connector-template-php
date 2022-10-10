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
     * @dataProvider \App\Tests\Functional\DataProvider\TranslationDataProvider::translationRequestWithoutAuthHeaderProvider
     *
     * @throws JsonException
     */
    public function testTranslateNotAuthorised(array $request, array $response): void
    {
        static::assertRequest(
            Request::METHOD_POST,
            '/v2/translate',
            $request,
            static::getTestConnectorConfigHeader(),
            $response,
            Response::HTTP_UNAUTHORIZED,
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\TranslationDataProvider::translationWithEmptyRequestProvider
     *
     * @throws JsonException
     */
    public function testTranslateEmptyRequest(array $response): void
    {
        static::assertRequest(
            method: Request::METHOD_POST,
            uri: '/v2/translate',
            server: static::getTestHeaders(),
            expectedResponse: $response,
            expectedStatusCode: Response::HTTP_BAD_REQUEST,
        );
    }
}
