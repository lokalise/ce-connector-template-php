<?php

namespace App\Integration\DTO;

/**
 * заголовки дополнительных столбцов, которые будут оторажаться в юай приложения лакалайз для вашего конектора
 */
class CacheItemStructure
{
    public function __construct(
        public readonly string $id = 'ID',
    ) {
    }
}
