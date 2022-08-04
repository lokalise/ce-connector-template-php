<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::authProvider
     */
    public function testAuth(string $key): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/auth',
            [
                "key" => $key,
            ],
            [
                "key" => $key,
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

    /**
     * @dataProvider \App\Tests\Functional\DataProvider\AuthenticationDataProvider::refreshProvider
     */
    public function testRefresh(string $refreshKey): void
    {
        static::checkRequest(
            Request::METHOD_POST,
            '/auth/refresh',
            [
                "refreshKey" => $refreshKey,
            ],
            [
                'key' => $refreshKey,
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
