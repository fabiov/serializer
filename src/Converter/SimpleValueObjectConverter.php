<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Converter;

use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\Exception\UnacceptableTargetClassException;
use CNastasi\Serializer\Contract\SimpleValueObject;
use CNastasi\Serializer\Contract\ValueObject;

class SimpleValueObjectConverter implements ValueObjectConverter
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
        return is_a($object, SimpleValueObject::class, true);
    }

    public function hydrate(string $targetClass, $value): ValueObject
    {
        if (!$this->accept($targetClass)) {
            throw new UnacceptableTargetClassException($targetClass);
        }

        return new $targetClass($value);
    }
}