<?php

namespace App\ArgumentResolver;

use App\DTO\Request\RequestDTO;
use App\Enum\ErrorCodeEnum;
use App\Enum\OAuthResponseParamsEnum;
use App\Exception\BadRequestHttpException;
use App\Formatter\BadRequestErrorsFormatter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * This resolver is triggered when the controller action has a parameter with the type {@link RequestDTO}.
 * Based on the incoming request, an object of type {@link RequestDTO} is created and passed to the controller action.
 *
 * @see https://symfony.com/doc/current/controller/argument_value_resolver.html#adding-a-custom-value-resolver
 */
class RequestDtoResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
        private readonly BadRequestErrorsFormatter $badRequestErrorsFormatter,
        private readonly OAuthResponseParamsEnum $defaultOAuthResponseParams,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), RequestDTO::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        try {
            /** @var RequestDTO $requestDTO */
            $requestDTO = $this->serializer->denormalize(
                $request->toArray(),
                $argument->getType(),
                JsonEncoder::FORMAT,
            );
        } catch (MissingConstructorArgumentsException) {
            throw new BadRequestHttpException(
                message: 'Bad request',
                errorCode: ErrorCodeEnum::CLIENT_ERROR,
            );
        }

        $this->validateRequest($requestDTO);

        yield $requestDTO;
    }

    private function validateRequest(RequestDTO $requestDTO): void
    {
        $violations = $this->validator->validate(
            value: $requestDTO,
            groups: [
                Constraint::DEFAULT_GROUP,
                $this->defaultOAuthResponseParams->value,
            ],
        );

        if (count($violations) > 0) {
            throw new BadRequestHttpException(
                'Bad request',
                $this->badRequestErrorsFormatter->format($violations),
                ErrorCodeEnum::CLIENT_ERROR,
            );
        }
    }
}
