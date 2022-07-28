<?php

namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedControllerInterface;
use App\TokenExtractor\TokenExtractorInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly TokenExtractorInterface $tokenExtractor,
    ) {
    }

    #[ArrayShape([
        KernelEvents::CONTROLLER => 'string',
    ])]
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

        if (!$controller instanceof TokenAuthenticatedControllerInterface) {
            return;
        }

        $accessToken = $this->tokenExtractor->extract($event->getRequest());

        if (!$accessToken) {
            throw new AccessDeniedHttpException('Not authorised');
        }
    }
}
