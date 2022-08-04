<?php

namespace App\DTO;

class TranslationItem extends Identifier
{
    /**
     * @var array<string, string>|null
     */
    public ?array $translations = null;
}
