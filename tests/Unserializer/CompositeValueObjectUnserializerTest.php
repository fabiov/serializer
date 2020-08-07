<?php

namespace CNastasi\Serializer\Unserializer;

use CNastasi\Example\Address;
use CNastasi\Example\Name;
use CNastasi\Example\Person;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionProperty;

/**
 * @covers \CNastasi\Serializer\Unserializer\CollectionUnserializer
 */
class CompositeValueObjectUnserializerTest extends TestCase
{
    private $unserializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->unserializer = new CompositeValueObjectUnserializer(new SimpleValueObjectUnserializer());
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function shouldUnserialize($class, $value)
    {
        $object = $this->unserializer->unserialize($value, $class);

        $this->assertInstanceOf($class, $object);

        $this->assertProperties($value, $object);
    }

    public function dataProvider()
    {
        yield [
            Address::class,
            [
                'street' => '167 Main Street',
                'city'   => 'Boston'
            ]
        ];

        $name   = 'John Smith';
        $age    = 37;
        $street = '156 Somewhere Street';
        $city   = 'NYC';

        yield [
            Person::class,
            [
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
            ]
        ];
    }

    private function assertProperties($data, object $object)
    {
        $class      = new ReflectionClass($object);
        $properties = $class->getProperties();

        foreach ($properties as $property) {
            $name = $property->getName();
            $type = $property->getType();

            $value = $this->getValue($object, $property);

            if ($type->isBuiltin() || $data === null) {
                $this->assertEquals($data[$name], $value);
            }
        }
    }

    private function getValue(object $object, ReflectionProperty $property)
    {
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
