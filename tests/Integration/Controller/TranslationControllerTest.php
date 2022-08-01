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
                        "uniqueId" => "post:1:title",
                        "groupId" => "post:1",
                        "metadata" => [
                            "contentType" => "post",
                            "field" => "title",
                        ],
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
                [
                    "groupId" => "post:1",
                    "uniqueId" => "post:1:title",
                    "metadata" => [
                        "contentType" => "post",
                        "field" => "title",
                    ],
                ],
            ],
        ];
    }
}
