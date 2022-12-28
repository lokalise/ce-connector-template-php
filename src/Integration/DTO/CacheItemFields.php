<?php

namespace App\Integration\DTO;

use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * Fields that will contain values for columns that have been defined using the {@link CacheItemStructure}.
 */
class CacheItemFields
{
    public function __construct(
        public readonly string $id,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public readonly \DateTime $createdAt,
    ) {
    }
}
