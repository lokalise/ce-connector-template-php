<?php

namespace App\TokenExtractor;

use Symfony\Component\HttpFoundation\Request;

interface TokenExtractorInterface
{
    public function extract(Request $request): ?string;
}