<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use App\Tests\Integration\Service\AuthenticationTestService;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationControllerTest extends AbstractApiTestCase
{
    public function testAuth(): void
    {
        $keyData = [
            "key" => AuthenticationTestService::KEY,
        ];

        static::checkRequest(
            Request::METHOD_POST,
            '/auth',
            $keyData,
            $keyData
        );
    }

    public function testAuthEmptyRequest(): void
    {
        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/auth'
        );
    }

    public function testRefresh(): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/auth/refresh',
            [
                "refreshKey" => AuthenticationTestService::REFRESH_KEY,
            ],
            [
                'key' => AuthenticationTestService::REFRESH_KEY,
            ]
        );
    }

    public function testRefreshEmptyRequest(): void
    {
        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/auth/refresh'
        );
    }
}
