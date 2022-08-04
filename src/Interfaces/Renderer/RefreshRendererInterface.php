<?php

namespace App\Interfaces\Renderer;

use Symfony\Component\HttpFoundation\Response;

interface RefreshRendererInterface
{
    public function render(string $refreshKey): Response;
}
