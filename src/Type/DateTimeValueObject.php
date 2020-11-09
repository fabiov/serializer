<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Contract\ValueObject;

interface DateTimeValueObject extends ValueObject, \Stringable
{
    public static function now(): static;

    public static function fromDateTime(\DateTimeInterface $dateTime): static;

    public static function fromString(string $dateTime): static;

    public function toDateTime(): \DateTimeInterface;

    public function toString(): string;
}