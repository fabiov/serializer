<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Serializer\Exception\UnacceptableTargetClassException;
use CNastasi\Serializer\ValueObject\SimpleValueObject;

class SimpleValueObjectUnserializer implements ValueObjectUnserializer
{
    public function unserialize($value, string $targetClass): object
    {
        if (!is_subclass_of($targetClass, SimpleValueObject::class, true)) {
            throw new UnacceptableTargetClassException($targetClass);
        }

        return new $targetClass($value);
    }
}