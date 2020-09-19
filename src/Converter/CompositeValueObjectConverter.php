<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Converter;

use CNastasi\Serializer\Contract\CompositeValueObject;
use CNastasi\Serializer\Contract\LoopGuardAware;
use CNastasi\Serializer\Contract\SerializerAware;
use CNastasi\Serializer\Contract\ValueObject;
use CNastasi\Serializer\Exception\NullValueFoundException;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\Exception\UnacceptableTargetClassException;
use CNastasi\Serializer\Exception\WrongTypeException;
use CNastasi\Serializer\LoopGuardAwareTrait;
use CNastasi\Serializer\SerializerAwareTrait;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

class CompositeValueObjectConverter implements ValueObjectConverter, SerializerAware, LoopGuardAware
{
    use SerializerAwareTrait;
    use LoopGuardAwareTrait;

    public function serialize(object $object)
    {
        if (!$this->accept($object)) {
            throw new UnableToSerializeException($object);
        }

        $data = [];

        $this->loopGuard->addReferenceCount($object);

        $properties = $this->getProperties($object);

        foreach ($properties as $property) {
            $name = $property->getName();
            $value = $this->getValue($object, $property);

            $data[$name] = $this->serializer->serialize($value, false);
        }

        return $data;
    }

    public function hydrate(string $targetClass, $data): ValueObject
    {
        if (!$this->accept($targetClass)) {
            throw new UnacceptableTargetClassException($targetClass);
        }

        if (!is_array($data)) {
            throw new WrongTypeException($data, 'array');
        }

        $class = new ReflectionClass($targetClass);

        $parameters = $this->getConstructorParameters($class);

        $args = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $typeAsString = $type->getName();
            $name = $parameter->getName();

            $value = $data[$name];

            if ($value === null && !$type->allowsNull()) {
                throw new NullValueFoundException($name, $typeAsString);
            }

            $args[$name] = $value
                ? $this->serializer->hydrate($typeAsString, $value, false)
                : null;
        }

        /** @var ValueObject $result */
        $result = $class->newInstanceArgs($args);

        return $result;
    }

    public function accept($object): bool
    {
        return is_a($object, CompositeValueObject::class, true);
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

        $parentClass = $class->getParentClass();

        return $parentClass
            ? array_merge($this->getProperties($parentClass), $class->getProperties())
            : $class->getProperties();
    }

    private function getConstructorParameters(ReflectionClass $class): array
    {
        $constructor = $class->getConstructor();

        return $constructor ? $constructor->getParameters() : [];
    }
}