<?php

namespace App\Interfaces\Renderer;

use Symfony\Component\HttpFoundation\Response;

interface PublishRendererInterface
{
    public function render(): Response;
}