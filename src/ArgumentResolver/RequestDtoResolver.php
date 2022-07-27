<?php

namespace App\ArgumentResolver;

use App\DTO\Request\RequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestDtoResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), RequestDTO::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $requestDTO = $this->serializer->denormalize($request->toArray(), $argument->getType(), JsonEncoder::FORMAT);
        $violations = $this->validator->validate($requestDTO);

        if (count($violations) > 0) {
            throw new BadRequestHttpException((string)$violations);
        }

        yield $requestDTO;
    }
}
