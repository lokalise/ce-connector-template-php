<?php

namespace App\EventSubscriber;

use App\Controller\AuthenticatedControllerInterface;
use App\Exception\ExtractorNotExistException;
use App\Integration\DTO\AccessCredentials;
use App\RequestValueExtractor\RequestValueExtractorFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthCredentialsSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RequestValueExtractorFactory $requestValueExtractorFactory,
    ) {
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    /**
     * @throws ExtractorNotExistException
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if (!$controller instanceof AuthenticatedControllerInterface) {
            return;
        }

        $apiKeyExtractor = $this->requestValueExtractorFactory->factory(AccessCredentials::class);
        $apiKey = $apiKeyExtractor->extract($event->getRequest());

        if (!$apiKey) {
            throw new AccessDeniedHttpException('Not authorised');
        }
    }
}
