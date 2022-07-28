<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use LogicException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

abstract class AbstractApiTestCase extends KernelTestCase
{
    protected static function createClient(): KernelBrowser
    {
        try {
            /** @var KernelBrowser $client */
            $client = static::getContainer()->get('test.client');
        } catch (ServiceNotFoundException) {
            if (class_exists(KernelBrowser::class)) {
                throw new LogicException(
                    'You cannot create the client used in functional tests if the "framework.test" config is not set to true.'
                );
            }

            throw new LogicException(
                'You cannot create the client used in functional tests if the BrowserKit component is not available. Try running "composer require symfony/browser-kit".'
            );
        }

        return $client;
    }
}
