<?php

namespace App\ArgumentResolver;

use App\Enum\AuthTypeEnum;
use App\Exception\ExtractorNotExistException;
use App\Integration\DTO\AuthCredentials;
use App\Interfaces\DataTransformer\AuthCredentialsTransformerInterface;
use App\RequestValueExtractor\RequestValueExtractorFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthCredentialsResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly RequestValueExtractorFactory $requestValueExtractorFactory,
        private readonly AuthCredentialsTransformerInterface $authCredentialsDataTransformer,
        private readonly ValidatorInterface $validator,
        private readonly AuthTypeEnum $defaultAuthType,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === AuthCredentials::class;
    }

    /**
     * @throws ExtractorNotExistException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $apiKeyExtractor = $this->requestValueExtractorFactory->factory(AuthCredentials::class);
        $apiKey = $apiKeyExtractor->extract($request);

        if ($apiKey === null) {
            throw new BadRequestHttpException('Authentication header should not be blank.');
        }

        $authCredentials = $this->authCredentialsDataTransformer->transform($apiKey);

        $violations = $this->validator->validate(
            value: $authCredentials,
            groups: [
                Constraint::DEFAULT_GROUP,
                $this->defaultAuthType->value,
            ],
        );

        if (count($violations) > 0) {
            throw new BadRequestHttpException((string) $violations);
        }

        yield $authCredentials;
    }
}
