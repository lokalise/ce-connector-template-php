<?php

namespace App\ArgumentResolver;

use App\DataTransformer\AuthCredentialsTransformer;
use App\DTO\ErrorDetails\BadRequestErrorDetails;
use App\Exception\BadRequestHttpException;
use App\Exception\ExtractorNotExistException;
use App\Formatter\BadRequestErrorsFormatter;
use App\Integration\DTO\AuthCredentials;
use App\RequestValueExtractor\AuthCredentialsExtractor;
use App\RequestValueExtractor\RequestValueExtractorFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * данный резолвер срабатывает когда у экшена контроллера есть параметр с типом AuthCredentials
 * На основе входящего реквеста создается объект типа AuthCredentials который возвращается и передается экшену контроллера
 *
 * @link https://symfony.com/doc/current/controller/argument_value_resolver.html#adding-a-custom-value-resolver
 */
class AuthCredentialsResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly RequestValueExtractorFactory $requestValueExtractorFactory,
        private readonly AuthCredentialsTransformer $authCredentialsDataTransformer,
        private readonly ValidatorInterface $validator,
        private readonly BadRequestErrorsFormatter $badRequestErrorsFormatter,
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
            throw new BadRequestHttpException(
                'Invalid authentication data',
                new BadRequestErrorDetails([
                    [
                        AuthCredentialsExtractor::AUTH_CREDENTIALS_HEADER => ['Authentication header should not be blank.'],
                    ],
                ]),
            );
        }

        $authCredentials = $this->authCredentialsDataTransformer->transform($apiKey);

        $this->validateAuthCredentials($authCredentials);

        yield $authCredentials;
    }

    private function validateAuthCredentials(AuthCredentials $authCredentials): void
    {
        /** @var ConstraintViolationListInterface|array<int, ConstraintViolationInterface> $violations */
        $violations = $this->validator->validate($authCredentials);

        if (count($violations) > 0) {
            $errors = $this->badRequestErrorsFormatter->format($violations);

            throw new BadRequestHttpException(
                'Invalid authentication data',
                new BadRequestErrorDetails([$errors]),
            );
        }
    }
}
