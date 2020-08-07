<?php

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Example\Age;
use CNastasi\Example\Classroom;
use CNastasi\Example\Name;
use CNastasi\Example\Phone;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CNastasi\Serializer\Unserializer\CollectionUnserializer
 */
class CollectionUnserializerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldUnserialize()
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

        $simpleValueObjectUnserializer = new SimpleValueObjectUnserializer();
        $compositeValueObjectUnserializer = new CompositeValueObjectUnserializer($simpleValueObjectUnserializer);

        $unserializer = new CollectionUnserializer($compositeValueObjectUnserializer, $simpleValueObjectUnserializer);

        $object = $unserializer->unserialize($names, Classroom::class);

        $this->assertInstanceOf(Classroom::class, $object);
        $this->assertEquals($classroom, $object);
    }

    public function dataProvider()
    {
        yield [42, Age::class];
        yield ['Jade Brown', Name::class];
        yield ['+39 124566789', Phone::class];
    }
}
