<?php

namespace CNastasi\Serializer\Contract;

/**
 * @template T
 */
interface SimpleValueObject extends ValueObject
{
    /**
     * SimpleValueObject constructor.
     *
     * @phpstan-param T $value
     *
     * @param mixed $value
     */
    public function __construct($value);

    /**
     * @return mixed
     * @phpstan-return T
     */
    public function value();
}