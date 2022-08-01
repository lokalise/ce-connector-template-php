<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

class TranslationControllerTest extends AbstractApiTestCase
{
    public function testTranslate(): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/translate',
            $this->getTranslateRequestParameters(),
            [
                "items" => [
                    [
                        "translations" => [
                            "en" => "en",
                            "en_US" => "en_US",
                            "ru" => "ru",
                        ],
                        "uniqueId" => AbstractApiTestCase::UNIQUE_ID,
                        "groupId" => AbstractApiTestCase::GROUP_ID,
                        "metadata" => AbstractApiTestCase::METADATA,
                    ],
                ],
            ],
            static::getTestTokenHeader()
        );
    }

    public function testTranslateNotAuthorised(): void
    {
        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/translate',
            $this->getTranslateRequestParameters()
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

    private function getTranslateRequestParameters(): array
    {
        return [
            "locales" => [
                "en",
                "en_US",
                "ru",
            ],
            "items" => [
                AbstractApiTestCase::UNIQUE_ITEM_IDENTIFIER,
            ],
        ];
    }
}
