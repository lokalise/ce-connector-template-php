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
 * данный резолвер срабатывает когда у экшена контроллера есть параметр с типом ConnectorConfig
 * На основе входящего реквеста создается объект типа ConnectorConfig который возвращается и передается экшену контроллера
 *
 * @link https://symfony.com/doc/current/controller/argument_value_resolver.html#adding-a-custom-value-resolver
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
        return $argument->getType() === ConnectorConfig::class;
    }

    /**
     * @throws ExtractorNotExistException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $connectorConfigExtractor = $this->requestValueExtractorFactory->factory(ConnectorConfig::class);
        $encodedConnectorConfig = $connectorConfigExtractor->extract($request);

        if ($encodedConnectorConfig === null) {
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
