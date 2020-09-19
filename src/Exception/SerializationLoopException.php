<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

use RuntimeException;

class SerializationLoopException extends RuntimeException
{
    public function __construct(object $object)
    {
        parent::__construct('Serialization stopped due a loop caused by the object ' . get_class($object));
    }
}