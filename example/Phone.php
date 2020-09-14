<?php

namespace CNastasi\Example;

use CNastasi\Serializer\Contract\SimpleValueObject;

class Phone implements SimpleValueObject
{
    private string $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}