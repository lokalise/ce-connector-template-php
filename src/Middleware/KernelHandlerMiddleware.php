<?php

namespace App\Middleware;

use Baldinof\RoadRunnerBundle\Http\MiddlewareInterface;
use Symfony\Component\ErrorHandler\ErrorRenderer\SerializerErrorRenderer;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ErrorController;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class KernelHandlerMiddleware implements MiddlewareInterface
{
    public function __construct(
        private EventDispatcherInterface $dispatcher,
        private SerializerInterface $serializer,
    ) {
    }

    public function process(Request $request, HttpKernelInterface $next): \Iterator
    {
        try {
            yield $next->handle($request);
        } catch (\Throwable $exception) {
            $this->dispatcher->addListener(
                KernelEvents::CONTROLLER_ARGUMENTS,
                function (ControllerArgumentsEvent $controllerEvent) use ($exception, $next) {
                    $errorRenderer = new SerializerErrorRenderer($this->serializer, JsonEncoder::FORMAT);
                    $errorController = new ErrorController($next, null, $errorRenderer);

                    $controllerEvent->setController($errorController);
                    $controllerEvent->setArguments([$exception]);
                }
            );

            yield $next->handle($request);
        }
    }
}
