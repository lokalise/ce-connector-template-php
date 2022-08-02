<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use App\Tests\Integration\Service\AuthenticationTestService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationControllerTest extends AbstractApiTestCase
{
    public function testAuth(): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/auth',
            [
                "key" => 'irure dolor in',
            ],
            [
                "key" => AuthenticationTestService::KEY,
            ]
        );
    }

    public function testAuthEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

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
                "refreshKey" => 'dolor Excepteur exercitation',
            ],
            [
                'key' => AuthenticationTestService::REFRESH_KEY,
            ]
        );
    }

    public function testRefreshEmptyRequest(): void
    {
        $this->expectException(BadRequestHttpException::class);

        static::checkEmptyRequest(
            Request::METHOD_POST,
            '/auth/refresh'
        );
    }
}
