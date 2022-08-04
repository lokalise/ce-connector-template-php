<?php

namespace App\Interfaces\Renderer;

use App\DTO\EnvItem;
use Symfony\Component\HttpFoundation\Response;

interface EnvironmentRendererInterface
{
    /**
     * @param array<int, EnvItem> $environments
     */
    public function render(array $environments): Response;
}
