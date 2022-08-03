<?php

namespace App\Interfaces\Renderer;

use Symfony\Component\HttpFoundation\Response;

interface AuthRendererInterface
{
    public function render(string $key): Response;
}