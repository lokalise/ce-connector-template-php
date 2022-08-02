<?php

namespace App\Tests\Integration\Controller;

use App\Tests\Integration\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends AbstractApiTestCase
{
    public function testAuth(): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/',
            [],
            "OK"
        );
    }
}
