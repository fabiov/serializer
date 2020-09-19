<?php

namespace CNastasi\Serializer\Contract;

interface ValueObjectSerializer
{
    /**
     * @param mixed $object
     * @param bool $isRoot
     *
     * @return mixed
     */
    public function serialize($object, bool $isRoot = true);

    /**
     * @param string $targetClass
     * @param mixed $value
     * @param bool $isRoot
     *
     * @return ValueObject|int|string|null
     */
    public function hydrate(string $targetClass, $value, bool $isRoot = true);
}