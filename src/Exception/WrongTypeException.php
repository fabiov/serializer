<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

use RuntimeException;

class WrongTypeException extends RuntimeException
{
    public function __construct($value, string $expectedType)
    {
        parent::__construct("The value {$value} should be an {$expectedType}");
    }
}