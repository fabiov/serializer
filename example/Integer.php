<?php

declare(strict_types=1);

namespace CNastasi\Example;

use CNastasi\Serializer\Exception\OutOfRangeException;
use CNastasi\Serializer\Exception\WrongTypeException;
use CNastasi\Serializer\Contract\SimpleValueObject;


/**
 * Class Integer
 * @package CNastasi\Example
 *
 * @implements Primitive<int>
 */
abstract class Integer implements SimpleValueObject
{
    protected int $min = PHP_INT_MIN;

    protected int $max = PHP_INT_MAX;

    protected int $value;

    /**
     * @inheritDoc
     */
    public function __construct($value)
    {
        $this->assertIsInteger($value);
        $this->assertIsInRange($value);

        $this->value = $value;
    }

    /**
     * @inheritDoc
     *
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    private function assertIsInteger($value): void
    {
        if (!is_int($value)) {
            throw new WrongTypeException($value, 'Integer');
        }
    }


    private function assertIsInRange(int $value): void
    {
        if ($value < $this->min || $value > $this->max) {
            throw new OutOfRangeException($this->min, $this->max, $value);
        }
    }
}