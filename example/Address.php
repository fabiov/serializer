<?php

namespace CNastasi\Example;

use CNastasi\Serializer\ValueObject\CompositeValueObject;

class Address implements CompositeValueObject
{
    private string $street;

    private string $city;

    public function __construct(string $street, string $city)
    {
        $this->street = $street;
        $this->city   = $city;
    }
}