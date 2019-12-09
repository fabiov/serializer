<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

use RuntimeException;

class UnableToSerializeException extends RuntimeException
{
    public function __construct(object $object)
    {
        parent::__construct('Serializer was not able to serialize ' . get_class($object));
    }
}