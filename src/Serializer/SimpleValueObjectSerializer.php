<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\ValueObject\SimpleValueObject;

class SimpleValueObjectSerializer implements ValueObjectSerializer
{
    /**
     * @inheritDoc
     */
    public function serialize(object $object)
    {
        if (!$this->accept($object)) {
            throw new UnableToSerializeException($object);
        }

        return $object->value();
    }

    public function accept($object): bool
    {
        return $object instanceof SimpleValueObject;
    }
}