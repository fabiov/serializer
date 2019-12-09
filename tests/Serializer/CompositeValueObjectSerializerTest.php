<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Example\Address;
use CNastasi\Example\Age;
use CNastasi\Example\Name;
use CNastasi\Example\Person;
use CNastasi\Serializer\Exception\UnableToSerializeException;
use PHPUnit\Framework\TestCase;

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
    public function shouldSerialize1()
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
    public function shouldSerialize2()
    {
        $name   = 'John Smith';
        $age    = 37;
        $street = '156 Somewhere Street';
        $city   = 'NYC';

        $person = new Person(
            new Name($name),
            new Age($age),
            new Address($street, $city),
            null
        );

        $expectedResult = [
            'name'    => $name,
            'age'     => $age,
            'address' => [
                'street' => $street,
                'city'   => $city,
            ],
            'phone'   => null,
            'parent'  => [
                'name'    => $name,
                'age'     => $age,
                'address' => [
                    'street' => $street,
                    'city'   => $city,
                ],
                'phone'   => null,
                'parent'  => null
            ]
        ];

        $this->assertEquals($expectedResult, $this->serializer->serialize($person));
    }

    /**
     * @test
     */
    public function shouldRaiseAnExceptions()
    {
        $this->expectException(UnableToSerializeException::class);
        $this->expectExceptionMessage('Serializer was not able to serialize CNastasi\Example\Age');

        $this->serializer->serialize(new Age(44));
    }
}