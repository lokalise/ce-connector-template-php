<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

class TranslationControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider App\Tests\Integration\DataProvider\TranslationDataProvider::translationRequestParametersProvider
     */
    public function testTranslate(array $parameters, array $expectedResponse): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/translate',
            $parameters,
            $expectedResponse,
            static::getTestTokenHeader()
        );
    }

    /**
     * @dataProvider App\Tests\Integration\DataProvider\TranslationDataProvider::translationRequestParametersProvider
     */
    public function testTranslateNotAuthorised(array $parameters): void
    {
        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/translate',
            $parameters
        );
    }

    public function testTranslateEmptyRequest(): void
    {
        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/translate',
            static::getTestTokenHeader()
        );
    }
}
