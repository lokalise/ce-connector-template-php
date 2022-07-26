<?php

namespace App\Interfaces;

use App\DTO\Response\TranslationResponse;

interface TranslationRendererInterface
{
    public function render(array $items): TranslationResponse;
}