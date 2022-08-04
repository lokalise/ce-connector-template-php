<?php

namespace App\DTO;

class Token
{
    public function __construct(
        public readonly ?string $value = null
    ) {
    }
}
