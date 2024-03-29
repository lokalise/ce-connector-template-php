<?php

namespace App\EventSubscriber;

use App\Controller\AuthenticatedControllerInterface;
use App\Exception\ExtractorNotExistException;
use App\Exception\UnauthorizedHttpException;
use App\Integration\DTO\AuthCredentials;
use App\RequestValueExtractor\RequestValueExtractorFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * This subscriber is triggered before an action of controller which implements the AuthenticatedControllerInterface.
 * Subscriber checks if authorization header is present.
 */
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

        $apiKeyExtractor = $this->requestValueExtractorFactory->factory(AuthCredentials::class);
        $apiKey = $apiKeyExtractor->extract($event->getRequest());

        if (!$apiKey) {
            throw new UnauthorizedHttpException(error: 'Invalid api key');
        }
    }
}
