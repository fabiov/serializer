<?php

namespace CNastasi\Serializer;

use CNastasi\Example\Address;
use CNastasi\Example\Age;
use CNastasi\Example\Name;
use CNastasi\Example\Phone;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use Cnastasi\Serializer\Serializer\CompositeValueObjectSerializer;
use CNastasi\Serializer\Serializer\SimpleValueObjectSerializer;
use CNastasi\Serializer\Serializer\ValueObjectSerializerDefault;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CNastasi\Serializer\Serializer\ValueObjectSerializerDefault
 */
class ValueObjectSerializerTest extends TestCase
{
    private ValueObjectSerializerDefault $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $simpleValueObjectSerializer    = new SimpleValueObjectSerializer();
        $compositeValueObjectSerializer = new CompositeValueObjectSerializer($simpleValueObjectSerializer);

        $this->serializer = new ValueObjectSerializerDefault(
            [$simpleValueObjectSerializer, $compositeValueObjectSerializer]
        );
    }

    /**
     * @test
     */
    public function shouldSerializeASimpleValueObject()
    {
        $age   = 37;
        $name  = 'John Smith';
        $phone = '+39 98765321';

        $this->assertEquals($age, $this->serializer->serialize(new Age($age)));
        $this->assertEquals($name, $this->serializer->serialize(new Name($name)));
        $this->assertEquals($phone, $this->serializer->serialize(new Phone($phone)));
    }

    /**
     * @test
     */
    public function shouldSerializeACompositeValueObject()
    {
        $street = '115 Somewhere Street';
        $city   = 'Unknown Town';

        $this->assertEquals([
            'city'   => $city,
            'street' => $street
        ],
            $this->serializer->serialize(new Address($street, $city))
        );
    }

    /**
     * @test
     */
    public function shouldRaiseAnException()
    {
        $this->expectException(UnableToSerializeException::class);

        $object = (object)['pippo' => 'a', 'pluto' => 'b'];

        $this->serializer->serialize($object);
    }

}
