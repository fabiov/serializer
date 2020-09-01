<?php

namespace CNastasi\Serializer\Serializer;

use CNastasi\Example\Address;
use CNastasi\Example\Age;
use CNastasi\Example\Classroom;
use CNastasi\Example\Name;
use CNastasi\Example\Phone;
use CNastasi\Serializer\Exception\UnableToSerializeException;
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

        $simpleValueObjectSerializer = new SimpleValueObjectSerializer();
        $compositeValueObjectSerializer = new CompositeValueObjectSerializer($simpleValueObjectSerializer);
        $collectionSerializer = new CollectionSerializer($compositeValueObjectSerializer);

        $this->serializer = new ValueObjectSerializerDefault(
            [
                $simpleValueObjectSerializer,
                $compositeValueObjectSerializer,
                $collectionSerializer
            ]
        );
    }

    /**
     * @test
     */
    public function shouldSerializeASimpleValueObject()
    {
        $age = 37;
        $name = 'John Smith';
        $phone = '+39 98765321';

        self::assertEquals($age, $this->serializer->serialize(new Age($age)));
        self::assertEquals($name, $this->serializer->serialize(new Name($name)));
        self::assertEquals($phone, $this->serializer->serialize(new Phone($phone)));
    }

    /**
     * @test
     */
    public function shouldSerializeACompositeValueObject()
    {
        $street = '115 Somewhere Street';
        $city = 'Unknown Town';

        self::assertEquals(
            [
                'city' => $city,
                'street' => $street
            ],
            $this->serializer->serialize(new Address($street, $city))
        );
    }

    /**
     * @test
     */
    public function shouldSerializeACollection()
    {
        $names = [
            "Pippo Franco",
            'Mario Mario',
            'Ginetto',
        ];

        $classroom = new Classroom();
        $classroom->addItem(new Name('Pippo Franco'));
        $classroom->addItem(new Name('Mario Mario'));
        $classroom->addItem(new Name('Ginetto'));

        self::assertEquals($names, $this->serializer->serialize($classroom));
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
