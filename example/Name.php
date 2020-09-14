<?php

namespace CNastasi\Example;

use CNastasi\Serializer\Contract\SimpleValueObject;

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