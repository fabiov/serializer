<?php

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Serializer\ValueObject\ValueObject;

interface ValueObjectUnserializer
{
    public function unserialize($value, string $targetClass): ValueObject;
}