<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Serializer\Exception\UnacceptableTargetClassException;
use CNastasi\Serializer\Exception\WrongTypeException;
use CNastasi\Serializer\ValueObject\Collection;
use CNastasi\Serializer\ValueObject\SimpleValueObject;
use CNastasi\Serializer\ValueObject\ValueObject;

class CollectionUnserializer implements ValueObjectUnserializer
{
    private CompositeValueObjectUnserializer $compositeValueObjectUnserializer;
    private SimpleValueObjectUnserializer $simpleValueObjectUnserializer;

    public function __construct(
        CompositeValueObjectUnserializer $compositeValueObjectUnserializer,
        SimpleValueObjectUnserializer $simpleValueObjectUnserializer
    ) {
        $this->compositeValueObjectUnserializer = $compositeValueObjectUnserializer;
        $this->simpleValueObjectUnserializer = $simpleValueObjectUnserializer;
    }

    public function unserialize($value, string $targetClass): ValueObject
    {
        if (!is_subclass_of($targetClass, Collection::class, true)) {
            throw new UnacceptableTargetClassException($targetClass);
        }

        if (!is_array($value) && !$value instanceof \Iterable) {
            throw new WrongTypeException(get_class($value), 'Iterable');
        }

        /** @var Collection $collection */
        $collection = new $targetClass();

        foreach ($value as $item) {
            $collection->addItem(
                $this->unserializeValueObject($item, $collection->getItemType())
            );
        }

        return $collection;
    }

    private function unserializeValueObject($value, string $targetClass): ValueObject
    {
        return is_subclass_of($targetClass, SimpleValueObject::class, true)
            ? $this->simpleValueObjectUnserializer->unserialize($value, $targetClass)
            : $this->compositeValueObjectUnserializer->unserialize($value, $targetClass);
    }
}