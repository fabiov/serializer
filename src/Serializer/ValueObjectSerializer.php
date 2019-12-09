<?php

namespace CNastasi\Serializer\Serializer;

interface ValueObjectSerializer
{
    /**
     * @param object $object
     *
     * @return mixed
     */
    public function serialize(object $object);

    public function accept($object):bool;
}