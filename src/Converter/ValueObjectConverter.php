<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Converter;

use CNastasi\Serializer\Contract\ValueObject;

interface ValueObjectConverter
{
    /**
     * @param object $object
     *
     * @return mixed
     */
    public function serialize(object $object);

    public function hydrate(string $targetClass, $value): ValueObject;

    /**
     * @param object|string $object
     *
     * @return bool
     */
    public function accept($object): bool;
}