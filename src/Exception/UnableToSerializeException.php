<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

use RuntimeException;

class UnableToSerializeException extends RuntimeException
{
    /**
     * @param object|string $object
     */
    public function __construct($object)
    {
        $className = is_object($object) ? get_class($object) : $object;

        parent::__construct("Serializer was not able to serialize {$className}");
    }
}