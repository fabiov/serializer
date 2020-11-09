<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Attribute\Primitive;
use CNastasi\Serializer\Exception\InvalidString;

#[Primitive(factory: 'fromString', getter: 'toString')]
class Text implements \Stringable
{
    protected string $regex = '/.?/';

    protected string $value;

    protected function __construct(string $value)
    {
        $this->assertIsValid($value);

        $this->value = $value;
    }

    private function assertIsValid(string $value): void
    {
        $result = preg_match($this->regex, $value);

        if ($result === 0) {
            throw new InvalidString($this->regex, $value);
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }
}