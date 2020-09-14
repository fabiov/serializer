<?php

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Serializer\Contract\ValueObject;

interface ValueObjectUnserializer
{
    public function unserialize($value, string $targetClass): ValueObject;
}