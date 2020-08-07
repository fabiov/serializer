<?php

namespace CNastasi\Example;

use CNastasi\Serializer\ValueObject\SimpleValueObject;

class Name implements SimpleValueObject
{
    private string $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}