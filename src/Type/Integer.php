<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Attribute\Primitive;
use CNastasi\Serializer\Exception\IntegerOutOfRange;

#[Primitive(factory: 'fromInt', getter: 'toInt')]
class Integer
{
    protected int $min = PHP_INT_MIN;
    protected int $max = PHP_INT_MAX;

    protected int $value;

    protected function __construct(int $value)
    {
        $this->assertIsInRange($value);

        $this->value = $value;
    }

    private function assertIsInRange(int $value): void
    {
        if ($value < $this->min || $value > $this->max) {
            throw new IntegerOutOfRange($this->min, $this->max, $value);
        }
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public static function fromInt(int $value): static
    {
        return new static($value);
    }
}