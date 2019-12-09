<?php

namespace CNastasi\Serializer\Unserializer;

interface ValueObjectUnserializer
{
    public function unserialize($value, string $targetClass): object;
}