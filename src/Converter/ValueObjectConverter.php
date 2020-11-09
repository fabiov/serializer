<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Converter;

use CNastasi\Serializer\Attribute\ValueObject;

/**
 * @template T of ValueObject
 */
interface ValueObjectConverter
{
    /**
     * @phpstan-param T $object
     * @param object $object
     *
     * @return mixed
     */
    public function serialize(object $object);

    /**
     * @param class-string $targetClass
     * @param mixed $value
     *
     * @return ValueObject
     * @phpstan-return T
     */
    public function hydrate(string $targetClass, $value): ValueObject;

    /**
     * @param object|string $object
     *
     * @return bool
     */
    public function accept($object): bool;
}