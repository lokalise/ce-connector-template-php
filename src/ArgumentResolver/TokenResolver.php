<?php

namespace App\ArgumentResolver;

use App\DTO\Token;
use App\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class TokenResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private readonly TokenExtractorInterface $tokenExtractor,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === Token::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $accessToken = $this->tokenExtractor->extract($request);

        yield new Token($accessToken);
    }
}
