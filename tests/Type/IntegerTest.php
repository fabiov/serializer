<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Exception\IntegerOutOfRange;
use PHPUnit\Framework\TestCase;

/**
 * Class IntegerTest
 * @package CNastasi\Serializer\Type
 *
 * @covers \CNastasi\Serializer\Type\Integer
 */
class IntegerTest extends TestCase
{
    /**
     * @test
     */
    public function shouldInstantiate(): void
    {
        foreach ([0, 100, 42] as $value) {
            $integer = PositiveInteger::fromInt($value);

            self::assertSame($value, $integer->toInt());
        }
    }

    /**
     * @test
     */
    public function shouldFailIfLess(): void
    {
        $this->expectException(IntegerOutOfRange::class);

        PositiveInteger::fromInt(-10);
    }

    /**
     * @test
     */
    public function shouldFailIfMore(): void
    {
        $this->expectException(IntegerOutOfRange::class);

        PositiveInteger::fromInt(200);
    }
}

/**
 * Class PositiveInteger
 * @package CNastasi\Serializer\Type
 *
 * @internal
 */
class PositiveInteger extends Integer {
    protected int $min = 0;
    protected int $max = 100;
}
