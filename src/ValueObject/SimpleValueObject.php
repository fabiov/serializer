<?php

namespace CNastasi\Serializer\ValueObject;

interface SimpleValueObject
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
    public function __getPrimitiveValue();
}