<?php

namespace App\ArgumentResolver;

use App\DTO\Request\RequestDTO;
use App\Enum\AuthTypeEnum;
use App\Enum\OAuthResponseParamsEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
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
            $requestDTO = $this->serializer->denormalize(
                $request->toArray(),
                $argument->getType(),
                JsonEncoder::FORMAT,
            );
        } catch (MissingConstructorArgumentsException) {
            throw new BadRequestHttpException('Bad request');
        }

        $violations = $this->validator->validate(
            value: $requestDTO,
            groups: [
                Constraint::DEFAULT_GROUP,
                $this->defaultOAuthResponseParams->value,
            ],
        );

        if (count($violations) > 0) {
            throw new BadRequestHttpException((string) $violations);
        }

        yield $requestDTO;
    }
}
