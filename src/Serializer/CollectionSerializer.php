<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\ValueObject\Collection;

class CollectionSerializer implements ValueObjectSerializer
{
    private CompositeValueObjectSerializer $compositeValueObjectSerializer;

    public function __construct(CompositeValueObjectSerializer $compositeValueObjectSerializer)
    {
        $this->compositeValueObjectSerializer = $compositeValueObjectSerializer;
    }

    public function serialize(object $object)
    {
        if (!$this->accept($object)) {
            throw new UnableToSerializeException($object);
        }

        $result = [];

        foreach ($object as $item) {
            $result[] = $this->compositeValueObjectSerializer->serialize($item);
        }

        return $result;
    }

    public function accept($object): bool
    {
        return $object instanceof Collection;
    }
}