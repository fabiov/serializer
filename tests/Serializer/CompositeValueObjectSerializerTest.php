<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Example\Address;
use CNastasi\Example\Age;
use CNastasi\Example\Name;
use CNastasi\Example\Person;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use CNastasi\Serializer\ValueObject\CompositeValueObject;
use CNastasi\Serializer\ValueObject\SimpleValueObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CNastasi\Serializer\Serializer\CompositeValueObjectSerializer
 */
class CompositeValueObjectSerializerTest extends TestCase
{
    private CompositeValueObjectSerializer $serializer;

    public function setUp(): void
    {
        parent::setUp();

        $this->serializer = new CompositeValueObjectSerializer(new SimpleValueObjectSerializer());
    }

    /**
     * @test
     */
    public function test_plainComposite()
    {
        $street = '115 Somewhere Street';
        $city = 'Unknown Town';

        $this->assertEquals(
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
    public function test_nestedComposite()
    {
        $name = 'John Smith';
        $age = 37;
        $street = '156 Somewhere Street';
        $city = 'NYC';

        $person = new Person(
            new Name($name),
            new Age($age),
            new Address($street, $city),
            null
        );

        $expectedResult = [
            'name' => $name,
            'age' => $age,
            'address' => [
                'street' => $street,
                'city' => $city,
            ],
            'phone' => null,
            'parent' => [
                'name' => $name,
                'age' => $age,
                'address' => [
                    'street' => $street,
                    'city' => $city,
                ],
                'phone' => null,
                'parent' => null
            ]
        ];

        $this->assertEquals($expectedResult, $this->serializer->serialize($person));
    }

    public function test_simpleObject()
    {
        $age = 42;

        $this->assertSame(
            $age,
            $this->serializer->serialize(new Age($age))
        );
    }

    /**
     * @test
     */
    public function shouldRaiseAnExceptions1()
    {
        $this->expectException(UnableToSerializeException::class);
        $this->expectExceptionMessage('Serializer was not able to serialize stdClass');

        $this->serializer->serialize(new \stdClass());
    }
    /**
     * @test
     */
    public function shouldRaiseAnExceptions2()
    {
        $this->expectException(UnableToSerializeException::class);
        $this->expectExceptionMessage('Serializer was not able to serialize stdClass');

        $this->serializer->serialize(new class() implements CompositeValueObject {
            private \stdClass $property;

            public function __construct()
            {
                $this->property = new \stdClass();
            }
        });
    }

    /**
     * @test
     */
    public function shouldAcceptCompositeValueObject()
    {
        self::assertTrue($this->serializer->accept(new Address('ss', 'ss')));
        self::assertTrue($this->serializer->accept(new Age (42)));
        self::assertFalse($this->serializer->accept(new \stdClass()));
    }
}