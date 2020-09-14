<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Serializer\Contract\SerializerAware;
use CNastasi\Serializer\Contract\ValueObjectSerializer;
use CNastasi\Serializer\Exception\SerializationLoopException;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\Contract\CompositeValueObject;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use ReflectionType;

class CompositeValueObjectSerializer implements ValueObjectSerializer, SerializerAware
{
    private ValueObjectSerializer $serializer;
    private SerializationLoopGuard $loopGuard;


    public function __construct(SerializationLoopGuard $loopGuard)
    {
        $this->loopGuard = $loopGuard;
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    public function serialize(object $object)
    {
        if (!($object instanceof CompositeValueObject)) {
            throw new UnableToSerializeException($object);
        }

        $data = [];

        $this->loopGuard->addReferenceCount($object);

        $properties = $this->getProperties($object);

        foreach ($properties as $property) {
            $name = $property->getName();
            $type = $property->getType();
            $value = $this->getValue($object, $property);

            $data[$name] = $this->serializeProperty($property, $type, $value);
        }

        return $data;
    }

    public function accept($object): bool
    {
        return $object instanceof CompositeValueObject;
    }


    /**
     * @param object $object
     * @param ReflectionProperty $property
     *
     * @return mixed
     */
    private function getValue(object $object, ReflectionProperty $property)
    {
        $property->setAccessible(true);

        return $property->getValue($object);
    }


    /**
     * @param $object
     *
     * @return array
     *
     * @throws ReflectionException
     */
    private function getProperties(object $object): array
    {
        $class = $object instanceof ReflectionClass
            ? $object
            : new ReflectionClass($object);

        return array_merge($this->getProperties($class->getParentClass()), $class->getProperties());
    }

    private function serializeProperty(ReflectionProperty $property, ReflectionType $type, $value)
    {
        return ($type->isBuiltin() || $value === null)
            ? $value
            : $this->serializer->serialize($value);
    }

    public function setSerializer(ValueObjectSerializer $serializer): void
    {
        $this->serializer = $serializer;
    }
}
