<?php

namespace App\Validator;

use Attribute;
use BackedEnum;
use Symfony\Component\Validator\Constraints\NotBlank as BaseNotBlank;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Symfony\Component\Validator\Exception\InvalidOptionsException;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class NotBlank extends BaseNotBlank
{
    public function __set(string $option, mixed $value): void
    {
        if ('groups' === $option) {
            $this->groups = $this->normalizeGroups((array) $value);

            return;
        }

        throw new InvalidOptionsException(
            sprintf(
                'The option "%s" does not exist in constraint "%s".',
                $option,
                static::class,
            ),
            [$option],
        );
    }

    /**
     * @param array<int, string|BackedEnum> $groups
     *
     * @return array<int, string>
     */
    protected function normalizeGroups(array $groups): array
    {
        $normalized = [];
        foreach ($groups as $group) {
            if ($group instanceof BackedEnum) {
                $group = $group->value;
            }
            $normalized[] = $group;
        }

        return $normalized;
    }

    public function validatedBy(): string
    {
        return NotBlankValidator::class;
    }
}
