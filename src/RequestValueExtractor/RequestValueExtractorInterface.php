<?php

namespace App\RequestValueExtractor;

use Symfony\Component\HttpFoundation\Request;

interface RequestValueExtractorInterface
{
    public function extract(Request $request): ?string;
}
