<?php

namespace CNastasi\Example;

use CNastasi\Serializer\Type\PrimitiveValueObject;

#[Pri(min: 10, max: 100, regex: '/aaaa/')]
class Phone extends String
{
    #[String]private String $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}