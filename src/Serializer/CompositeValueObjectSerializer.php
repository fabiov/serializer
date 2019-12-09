<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\ValueObject\CompositeValueObject;
use CNastasi\Serializer\ValueObject\SimpleValueObject;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class CompositeValueObjectSerializer implements ValueObjectSerializer
{
    private const RECURSION_LOOPS = 2;
    private const MAX_RECURSION   = 50;

    private SimpleValueObjectSerializer $simpleValueObjectSerializer;

    public function __construct(SimpleValueObjectSerializer $simpleValueObjectSerializer)
    {
        $this->simpleValueObjectSerializer = $simpleValueObjectSerializer;
    }

    /**
     * @inheritDoc
     *
     * @throws ReflectionException
     */
    public function serialize(object $object)
    {
        $references = [];

        return $this->serializeRecursively($object, $references, 0);
    }

    /**
     * @param object             $object
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
     * @param object $object
     * @param array  $references
     * @param int    $depth
     *
     * @return array
     * @throws ReflectionException
     */
    private function serializeRecursively(object $object, array &$references, int $depth)
    {
        if (!($object instanceof CompositeValueObject)) {
            throw new UnableToSerializeException($object);
        }

        if ($this->thereIsALoop($object, $references)) {
            return null;
        }

        if ($depth >= self::MAX_RECURSION) {
            return null;
        }

        $data       = [];
        $class      = new ReflectionClass($object);
        $properties = $class->getProperties();

        foreach ($properties as $property) {
            $name = $property->getName();
            $type = $property->getType();

            $value = $this->getValue($object, $property);

            if ($type->isBuiltin() || $value === null) {
                $result = $value;
            } else if ($value instanceof SimpleValueObject) {
                $result = $this->simpleValueObjectSerializer->serialize($value);
            } else if ($value instanceof CompositeValueObject) {
                $result = $this->serializeRecursively($value, $references, $depth + 1);
            } else {
                throw new UnableToSerializeException($value);
            }

            $data[$name] = $result;
        }

        return $data;
    }

    private function thereIsALoop(CompositeValueObject $object, array &$references): bool
    {
        $objectId = spl_object_id($object);

        if (!isset($references[$objectId])) {
            $references[$objectId] = 0;
        }

        $references[$objectId]++;

        return $references[$objectId] > self::RECURSION_LOOPS;
    }

    public function accept($object): bool
    {
        return $object instanceof CompositeValueObject;
    }
}