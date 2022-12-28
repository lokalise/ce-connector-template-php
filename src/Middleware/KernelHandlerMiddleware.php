<?php

namespace App\Middleware;

use Baldinof\RoadRunnerBundle\Http\MiddlewareInterface;
use Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelHandlerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly EventDispatcherInterface $dispatcher,
        private readonly ErrorRendererInterface $errorRenderer,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function process(Request $request, HttpKernelInterface $next): \Iterator
    {
        try {
            yield $next->handle($request);
        } catch (\Throwable $exception) {
            $this->dispatcher->addListener(
                KernelEvents::CONTROLLER_ARGUMENTS,
                function (ControllerArgumentsEvent $controllerEvent) use ($exception, $next) {
                    $errorController = new ErrorController($next, null, $this->errorRenderer);

                    $controllerEvent->setController($errorController);
                    $controllerEvent->setArguments([$exception]);
                },
            );

            yield $next->handle($request);
        }
    }
}
