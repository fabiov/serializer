<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class IntegerOutOfRange extends ValueError
{
    public function __construct(int $min, int $max, int $value)
    {
        parent::__construct("Integer out of range. The number {$value} must have a value between {$min} and {$max}");
    }
}