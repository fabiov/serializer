<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

use RuntimeException;

class WrongTypeException extends RuntimeException
{
    /**
     * @param int|string $value
     * @param string $expectedType
     */
    public function __construct($value, string $expectedType)
    {
        parent::__construct("The value {$value} should be an {$expectedType}");
    }
}