<?php

namespace App\ArgumentResolver;

use App\Exception\ExtractorNotExistException;
use App\Integration\DTO\ConnectorConfig;
use App\Interfaces\DataTransformer\ConnectorConfigTransformerInterface;
use App\RequestValueExtractor\RequestValueExtractorFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConnectorConfigResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly RequestValueExtractorFactory $requestValueExtractorFactory,
        private readonly ConnectorConfigTransformerInterface $connectorConfigTransformer,
        private readonly ValidatorInterface $validator,
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
            throw new BadRequestHttpException('Configuration header should not be blank.');
        }

        $connectorConfig = $this->connectorConfigTransformer->transform($encodedConnectorConfig);

        $violations = $this->validator->validate($connectorConfig);

        if (count($violations) > 0) {
            throw new BadRequestHttpException((string) $violations);
        }

        yield $connectorConfig;
    }
}
