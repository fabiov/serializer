<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class NullValueFoundException extends \RuntimeException
{
    public function __construct(string $name, string $type)
    {
        parent::__construct("{$name} must be {$type}, null value found");
    }
}