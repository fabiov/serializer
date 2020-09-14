<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Serializer\Contract\SerializerAware;
use CNastasi\Serializer\Contract\ValueObjectSerializer;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\Contract\Collection;

class CollectionSerializer implements ValueObjectSerializer, SerializerAware
{
    private ValueObjectSerializer $serializer;

    private SerializationLoopGuard $loopGuard;

    public function __construct(SerializationLoopGuard $loopGuard)
    {
        $this->loopGuard = $loopGuard;
    }

    public function serialize($object)
    {
        if (!$this->accept($object)) {
            throw new UnableToSerializeException($object);
        }

        $this->loopGuard->addReferenceCount($object);

        $result = [];

        foreach ($object as $item) {
            $result[] = $this->serializer->serialize($item);
        }

        return $result;
    }

    public function accept($object): bool
    {
        return is_a($object, Collection::class, true);
    }

    public function setSerializer(ValueObjectSerializer $serializer): void
    {
        $this->serializer = $serializer;
    }
}