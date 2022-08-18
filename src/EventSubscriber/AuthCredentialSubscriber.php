<?php

namespace App\EventSubscriber;

use App\Controller\AuthenticatedControllerInterface;
use App\RequestValueExtractor\RequestValueExtractorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class AuthCredentialSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RequestValueExtractorInterface $apiKeyExtractor,
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

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if (!$controller instanceof AuthenticatedControllerInterface) {
            return;
        }

        $apiKey = $this->apiKeyExtractor->extract($event->getRequest());

        if (!$apiKey) {
            throw new AccessDeniedHttpException('Not authorised');
        }
    }
}
