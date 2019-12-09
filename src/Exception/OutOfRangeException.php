<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class OutOfRangeException extends \RuntimeException
{
    public function __construct(int $min, int $max, int $value)
    {
        parent::__construct("Number out of range. The number {$value} must have a value between {$min} and {$max}");
    }
}