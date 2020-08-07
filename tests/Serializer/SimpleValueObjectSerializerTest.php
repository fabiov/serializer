<?php

namespace CNastasi\Serializer\Serializer;

use CNastasi\Example\Address;
use CNastasi\Example\Age;
use CNastasi\Example\Name;
use CNastasi\Example\Phone;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CNastasi\Serializer\Serializer\SimpleValueObjectSerializer
 */
class SimpleValueObjectSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldSerialize()
    {
        $age   = 37;
        $name  = 'John Smith';
        $phone = '+39 98765321';

        $serializer = new SimpleValueObjectSerializer();

        $this->assertEquals($age, $serializer->serialize(new Age($age)));
        $this->assertEquals($name, $serializer->serialize(new Name($name)));
        $this->assertEquals($phone, $serializer->serialize(new Phone($phone)));
    }

    /**
     * @test
     */
    public function shouldRaiseAnExceptions()
    {
        $this->expectException(UnableToSerializeException::class);
        $this->expectExceptionMessage('Serializer was not able to serialize CNastasi\Example\Address');

        $serializer = new SimpleValueObjectSerializer();

        $serializer->serialize(new Address('something', 'something'));
    }
}
