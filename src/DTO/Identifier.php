<?php

namespace App\DTO;

use App\Integration\DTO\Metadata;
use Symfony\Component\Validator\Constraints as Assert;

class Identifier
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 256)]
        public readonly ?string $uniqueId = null,
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 256)]
        public readonly ?string $groupId = null,
        #[Assert\Valid]
        #[Assert\NotNull]
        public readonly ?Metadata $metadata = null,
    ) {
    }

    public static function createFromIdentifier(Identifier $identifier): static
    {
        return new static(
            $identifier->uniqueId,
            $identifier->groupId,
            $identifier->metadata,
        );
    }
}
