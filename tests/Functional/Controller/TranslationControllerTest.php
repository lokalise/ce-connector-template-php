<?php

namespace App\Tests\Functional\Controller;

use App\Exception\BadRequestHttpException;
use App\Exception\UnauthorizedHttpException;
use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;

class TranslationControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\TranslationDataProvider::translationProvider
     *
     * @throws JsonException
     */
    public function testTranslate(array $parameters, array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/v2/translate',
            $parameters,
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\TranslationDataProvider::translationRequestProvider
     *
     * @throws JsonException
     */
    public function testTranslateNotAuthorised(array $parameters): void
    {
        $this->expectException(UnauthorizedHttpException::class);

        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/v2/translate',
            $parameters
        );
    }

    /**
     * @throws JsonException
     */
    public function testTranslateEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/v2/translate',
            static::getTestTokenHeader()
        );
    }
}
