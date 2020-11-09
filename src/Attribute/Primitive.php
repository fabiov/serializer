<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Primitive extends ValueObject
{
    private string $factory;
    private string $getter;

    public function __construct(string $factory = 'make', string $getter = 'value')
    {
        $this->factory = $factory;
        $this->getter = $getter;
    }

    public function getFactory(): string
    {
        return $this->factory;
    }

    public function getGetter(): string
    {
        return $this->getter;
    }
}