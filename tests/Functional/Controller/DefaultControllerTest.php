<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
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
