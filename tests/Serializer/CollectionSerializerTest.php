<?php

namespace CNastasi\Serializer\Serializer;

use CNastasi\Example\Address;
use CNastasi\Example\Classroom;
use CNastasi\Example\Name;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CNastasi\Serializer\Serializer\CollectionSerializer
 */
class CollectionSerializerTest extends TestCase
{
    private CollectionSerializer $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = new CollectionSerializer(new CompositeValueObjectSerializer(new SimpleValueObjectSerializer()));
    }

    /**
     * @test
     */
    public function shouldSerialize()
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

        $this->serializer = new CollectionSerializer(new CompositeValueObjectSerializer(new SimpleValueObjectSerializer()));

        $result = $this->serializer->serialize($classroom);

        self::assertEquals($names, $result);
    }

    /**
     * @test
     */
    public function shouldRaiseAnExceptions()
    {
        $this->expectException(UnableToSerializeException::class);
        $this->expectExceptionMessage('Serializer was not able to serialize CNastasi\Example\Address');

        $this->serializer->serialize(new Address('something', 'something'));
    }
}
