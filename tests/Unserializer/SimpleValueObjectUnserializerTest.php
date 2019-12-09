<?php

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Example\Age;
use CNastasi\Example\Name;
use CNastasi\Example\Phone;
use PHPUnit\Framework\TestCase;

class SimpleValueObjectUnserializerTest extends TestCase
{
    /**
     * @test
     * @dataProvider dataProvider
     */
    public function shouldUnserialize($value, string $class)
    {
        $unserializer = new SimpleValueObjectUnserializer();

        $object = $unserializer->unserialize($value, $class);

        $this->assertInstanceOf($class, $object);
        $this->assertEquals($value, $object->__getPrimitiveValue());
    }

    public function dataProvider()
    {
        yield [42, Age::class];
        yield ['Jade Brown', Name::class];
        yield ['+39 124566789', Phone::class];
    }
}
