<?php

namespace App\Interfaces\Mapper;

use App\DTO\EnvItem;

interface EnvItemMapperInterface
{
    public function mapArrayToEnvItem(array $environment): EnvItem;
}
