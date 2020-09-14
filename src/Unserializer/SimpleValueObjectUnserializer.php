<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Serializer\Exception\UnacceptableTargetClassException;
use CNastasi\Serializer\Contract\SimpleValueObject;
use CNastasi\Serializer\Contract\ValueObject;

class SimpleValueObjectUnserializer implements ValueObjectUnserializer
{
    public function unserialize($value, string $targetClass): ValueObject
    {
        if (!is_subclass_of($targetClass, SimpleValueObject::class, true)) {
            throw new UnacceptableTargetClassException($targetClass);
        }

        return new $targetClass($value);
    }
}


// Simple
// composite
// collection