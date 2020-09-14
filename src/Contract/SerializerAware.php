<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Contract;

interface SerializerAware
{
    public function setSerializer(ValueObjectSerializer $serializer):void;
}