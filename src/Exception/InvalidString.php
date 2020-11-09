<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class InvalidString extends ValueError
{
    public function __construct(string $expected, string $value)
    {
        parent::__construct("Invalid string: expected '{$expected}', found '{$value}'");
    }
}
