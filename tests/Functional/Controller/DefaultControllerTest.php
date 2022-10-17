<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Functional\AbstractApiTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends AbstractApiTestCase
{
    /**
     * @dataProvider healthProvider
     */
    public function testHealthEndpoint(string $healthUrl): void
    {
        $client = static::createClient();

        $client->request(Request::METHOD_GET, $healthUrl);

        $response = $client->getResponse();

        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        $content = $response->getContent();

        self::assertNotEmpty($content);
        self::assertEquals('"OK"', $content);
    }

    public function healthProvider(): array
    {
        return [
            ['/'],
            ['/health'],
        ];
    }
}
