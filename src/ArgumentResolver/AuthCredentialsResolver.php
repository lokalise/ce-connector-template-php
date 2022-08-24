<?php

namespace App\ArgumentResolver;

use App\Integration\DTO\AuthCredentials;
use App\Interfaces\DataTransformer\AuthCredentialsTransformerInterface;
use App\RequestValueExtractor\RequestValueExtractorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class AuthCredentialsResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly RequestValueExtractorInterface $apiKeyExtractor,
        private readonly AuthCredentialsTransformerInterface $authCredentialsDataTransformer,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === AuthCredentials::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $apiKey = $this->apiKeyExtractor->extract($request);

        yield $this->authCredentialsDataTransformer->transform($apiKey);
    }
}
