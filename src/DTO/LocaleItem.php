<?php

namespace App\DTO;

class LocaleItem
{
    public function __construct(
        public readonly string $name,
        public readonly string $code,
    ) {
    }
}
