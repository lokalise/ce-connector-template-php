<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

class PublishControllerTest extends AbstractApiTestCase
{
    public function testPublish(): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/publish',
            $this->getPublishRequestParameters(),
            [
                "code" => "200",
                "message" => "Content successfully updated"
            ],
            static::getTestTokenHeader()
        );
    }

    public function testPublishNotAuthorised(): void
    {
        static::checkNotAuthorisedRequest(
            Request::METHOD_POST,
            '/publish',
            $this->getPublishRequestParameters()
        );
    }

    public function testPublishEmptyRequest(): void
    {
        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/publish',
            static::getTestTokenHeader()
        );
    }

    private function getPublishRequestParameters(): array
    {
        return [
            "items" => [
                [
                    "uniqueId" => AbstractApiTestCase::UNIQUE_ID,
                    "groupId" => AbstractApiTestCase::GROUP_ID,
                    "metadata" => AbstractApiTestCase::METADATA,
                    "translations" => [
                        "ge" => "Hallo Welt!",
                    ],
                ],
            ],
        ];
    }
}
