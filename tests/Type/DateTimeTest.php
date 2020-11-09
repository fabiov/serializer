<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Exception\InvalidDate;
use CNastasi\Serializer\Exception\InvalidDateTime;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeTest
 * @package CNastasi\Serializer\Type
 *
 * @covers \CNastasi\Serializer\Type\DateTime
 */
class DateTimeTest extends TestCase
{
    public function test_instantiate(): void
    {
        $day = 24;
        $month = 4;
        $year = 2020;
        $hours = 10;
        $minutes = 34;
        $seconds = 33;

        $dateTimeAsString = sprintf('%4d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hours, $minutes, $seconds);
        $dateTime = \DateTimeImmutable::createFromFormat(DateTime::FORMAT_Y_M_D_H_I_S, $dateTimeAsString);

        $dateTime1 = new DateTime(
            new Date($day, $month, $year),
            new Time($hours, $minutes, $seconds)
        );

        $dateTime2 = DateTime::fromString($dateTimeAsString);
        $dateTime3 = DateTime::fromDateTime($dateTime);

        self::assertEquals($dateTime1, $dateTime2);
        self::assertEquals($dateTime2, $dateTime3);
        self::assertEquals($dateTime1, $dateTime3);

        self::assertSame($dateTime->format(DateTime::FORMAT_Y_M_D_H_I_S), $dateTime1->toString());
        self::assertSame($dateTime->format(DateTime::FORMAT_Y_M_D_H_I_S), (string)$dateTime1);
        self::assertSame($dateTime->format(DateTime::FORMAT_Y_M_D_H_I_S), $dateTime1->toDateTime()->format(DateTime::FORMAT_Y_M_D_H_I_S));
    }

    public function test_wrong1(): void
    {
        $this->expectException(InvalidDateTime::class);

        DateTime::fromString('sdadsadsa');
    }

    public function test_wrong2(): void
    {
        $this->expectException(InvalidDateTime::class);

        DateTime::fromString('2020-10-15 dsdjadkls');
    }

    public function test_wrong3(): void
    {
        $this->expectException(InvalidDateTime::class);

        DateTime::fromString('dddddsd 10:20:30');
    }
}
