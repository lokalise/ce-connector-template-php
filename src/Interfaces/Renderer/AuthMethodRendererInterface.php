<?php

namespace App\Interfaces\Renderer;

use Symfony\Component\HttpFoundation\Response;

interface AuthMethodRendererInterface
{
    public function render(): Response;
}
