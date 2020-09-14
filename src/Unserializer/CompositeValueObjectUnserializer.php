<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Serializer\Exception\NullValueFoundException;
use CNastasi\Serializer\Exception\UnableToUnserializeException;
use CNastasi\Serializer\Contract\CompositeValueObject;
use CNastasi\Serializer\Contract\SimpleValueObject;
use CNastasi\Serializer\Contract\ValueObject;
use Exception;
use ReflectionClass;

class CompositeValueObjectUnserializer implements ValueObjectUnserializer
{
    private SimpleValueObjectUnserializer $simpleValueObjectUnserializer;

    public function __construct(SimpleValueObjectUnserializer $simpleValueObjectUnserializer)
    {
        $this->simpleValueObjectUnserializer = $simpleValueObjectUnserializer;
    }

    public function unserialize($data, string $targetClass): ValueObject
    {
        if (is_subclass_of($targetClass, SimpleValueObject::class, true)) {
            return $this->simpleValueObjectUnserializer->unserialize($data, $targetClass);
        }

        return $this->serializeComposite($targetClass, $data);
    }

    private function serializeComposite(string $targetClass, $data): object
    {
        $class = new ReflectionClass($targetClass);

        $costructor = $class->getConstructor();

        $parameters = $costructor->getParameters();

        $args = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $typeAsString = $type->getName();
            $name = $parameter->getName();
            $value = $data[$name];

            if ($value === null && !$type->allowsNull()) {
                throw new NullValueFoundException($name, (string) $type);
            }

            if ($type->isBuiltin() || $value === null) {
                $argument = $value;
            } else {
                if (is_subclass_of($typeAsString, SimpleValueObject::class, true)) {
                    $argument = $this->simpleValueObjectUnserializer->unserialize($value, $typeAsString);
                } else {
                    if (is_subclass_of($typeAsString, CompositeValueObject::class, true)) {
                        $argument = $this->unserialize($value, $typeAsString);
                    } else {
                        throw new UnableToUnserializeException($typeAsString);
                    }
                }
            }

            $args[$name] = $argument;
        }

        return $class->newInstanceArgs($args);
    }
}
