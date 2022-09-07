<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
use JsonException;
use Symfony\Component\HttpFoundation\Request;

class DefaultControllerTest extends AbstractApiTestCase
{
    /**
     * @throws JsonException
     */
    public function testHealthEndpoint(): void
    {
        static::checkRequest(
            Request::METHOD_GET,
            '/',
            [],
            'OK'
        );
    }
}
