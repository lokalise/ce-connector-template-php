<?php

namespace App\DTO\Response;

use App\DTO\EnvItem;

class EnvironmentResponse
{
    /**
     * @param array<int, EnvItem>
     */
    public function __construct(
        public readonly array $items,
    ) {
    }
}
