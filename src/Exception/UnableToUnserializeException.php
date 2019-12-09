<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

use RuntimeException;

class UnableToUnserializeException extends RuntimeException
{
    public function __construct(string $targetClass)
    {
        parent::__construct('Unserializer was not able to serialize ' . $targetClass);
    }
}