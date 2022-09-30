<?php

namespace App\ArgumentResolver;

use App\DataTransformer\ConnectorConfigTransformer;
use App\DTO\ErrorDetails\BadRequestErrorDetails;
use App\Exception\BadRequestHttpException;
use App\Exception\ExtractorNotExistException;
use App\Formatter\BadRequestErrorsFormatter;
use App\Integration\DTO\ConnectorConfig;
use App\RequestValueExtractor\ConnectorConfigExtractor;
use App\RequestValueExtractor\RequestValueExtractorFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * This resolver is triggered when the controller action has a parameter with the type {@link ConnectorConfig}.
 * Based on the incoming request, an object of type {@link ConnectorConfig} is created and passed to the controller action.
 *
 * @see https://symfony.com/doc/current/controller/argument_value_resolver.html#adding-a-custom-value-resolver
 */
class ConnectorConfigResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly RequestValueExtractorFactory $requestValueExtractorFactory,
        private readonly ConnectorConfigTransformer $connectorConfigTransformer,
        private readonly ValidatorInterface $validator,
        private readonly BadRequestErrorsFormatter $badRequestErrorsFormatter,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return ConnectorConfig::class === $argument->getType();
    }

    /**
     * @throws ExtractorNotExistException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $connectorConfigExtractor = $this->requestValueExtractorFactory->factory(ConnectorConfig::class);
        $encodedConnectorConfig = $connectorConfigExtractor->extract($request);

        if (null === $encodedConnectorConfig) {
            throw new BadRequestHttpException(
                'Invalid configuration data',
                new BadRequestErrorDetails([
                    [
                        ConnectorConfigExtractor::CONNECTOR_CONFIG_HEADER => [
                            'Configuration header should not be blank',
                        ],
                    ],
                ]),
            );
        }

        $connectorConfig = $this->connectorConfigTransformer->transform($encodedConnectorConfig);

        $this->validateConnectorConfig($connectorConfig);

        yield $connectorConfig;
    }

    private function validateConnectorConfig(ConnectorConfig $connectorConfig): void
    {
        /** @var ConstraintViolationListInterface|array<int, ConstraintViolationInterface> $violations */
        $violations = $this->validator->validate($connectorConfig);

        if (count($violations) > 0) {
            $errors = $this->badRequestErrorsFormatter->format($violations);

            throw new BadRequestHttpException(
                'Invalid configuration data',
                new BadRequestErrorDetails([$errors]),
            );
        }
    }
}
