<?php

declare(strict_types=1);

namespace CNastasi\Serializer;

use CNastasi\Serializer\Attribute\Primitive;
use CNastasi\Serializer\Attribute\ValueObject;
use CNastasi\Serializer\Type\Text;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class AttributesTest extends TestCase
{
    public function test(): void
    {
        $text = Text::fromString('Pippo');

        $reflectionClass = new ReflectionClass($text);

        $attributes = $reflectionClass->getAttributes();

        var_dump('Cacca');
        foreach ($attributes as $attribute) {

            var_dump($attribute->getName());

        }

    }
}