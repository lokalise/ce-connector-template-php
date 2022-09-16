<?php

namespace App\Interfaces\Renderer;

use App\Enum\AuthTypeEnum;
use Symfony\Component\HttpFoundation\Response;

interface AuthMethodRendererInterface
{
    public function render(): Response;
}
