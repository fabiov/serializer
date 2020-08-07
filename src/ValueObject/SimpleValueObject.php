<?php

namespace CNastasi\Serializer\ValueObject;

interface SimpleValueObject extends ValueObject
{
    /**
     * SimpleValueObject constructor.
     *
     * @param mixed $value
     */
    public function __construct($value);

    /**
     * @return mixed
     */
    public function value();
}