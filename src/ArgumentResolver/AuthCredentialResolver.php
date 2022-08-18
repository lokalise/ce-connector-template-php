<?php

namespace App\ArgumentResolver;

use App\Integration\DTO\AuthCredential;
use App\Interfaces\DataTransformer\AuthCredentialTransformerInterface;
use App\RequestValueExtractor\RequestValueExtractorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class AuthCredentialResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly RequestValueExtractorInterface $tokenExtractor,
        private readonly AuthCredentialTransformerInterface $authCredentialDataTransformer,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === AuthCredential::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $apiKey = $this->tokenExtractor->extract($request);

        yield $this->authCredentialDataTransformer->transform($apiKey);
    }
}
