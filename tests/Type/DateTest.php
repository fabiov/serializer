<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Exception\InvalidDate;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTest
 * @package CNastasi\Serializer\Type
 * @covers \CNastasi\Serializer\Type\Date
 */
class DateTest extends TestCase
{
    public function test_instantiate(): void
    {
        $day = 5;
        $month = 8;
        $year = 2020;

        $dateAsString = sprintf('%4d-%02d-%02d 10:20:34', $year, $month, $day);

        $datetime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateAsString);

        $date1 = Date::fromDateTime($datetime);
        $date2 = Date::fromString($datetime->format('Y-m-d'));
        $date3 = new Date($day, $month, $year);

        self::assertEquals($date1, $date2);
        self::assertEquals($date2, $date3);
        self::assertEquals($date1, $date3);

        self::assertSame($day, $date1->getDay());
        self::assertSame($month, $date1->getMonth());
        self::assertSame($year, $date1->getYear());

        self::assertSame($datetime->format('Y-m-d'), $date1->toString());
        self::assertSame($datetime->format('Y-m-d'), (string)$date1);
        self::assertSame($datetime->format('Y-m-d'), $date1->toDateTime()->format('Y-m-d'));
    }

    public function test_wrong1(): void
    {
        $this->expectException(InvalidDate::class);

        Date::fromString('sdadsadsa');
    }

    public function test_wrong2(): void
    {
        $this->expectException(InvalidDate::class);

        new Date(44, 3, 2500);
    }
}
