<?php

namespace CNastasi\Example;

use CNastasi\Serializer\ValueObject\SimpleValueObject;

class Phone implements SimpleValueObject
{
    private string $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __getPrimitiveValue()
    {
        return $this->value;
    }
}