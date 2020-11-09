<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Exception\InvalidDate;

class Date implements DateTimeValueObject
{
    public const FORMAT_Y_M_D = 'Y-m-d';

    private int $day;

    private int $month;

    private int $year;

    public function __construct(int $day, int $month, int $year)
    {
        $this->assertDateIsValid($day, $month, $year);

        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public static function now(): static
    {
        $date = getdate();

        return new static($date['mday'], $date['mon'], $date['year']);
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): static
    {
        $date = explode('-', $dateTime->format(self::FORMAT_Y_M_D));

        $day = (int)$date[2];
        $month = (int)$date[1];
        $year = (int)$date[0];

        return new static($day, $month, $year);
    }

    public static function fromString(string $date): static
    {
        $dateTime = \DateTimeImmutable::createFromFormat(self::FORMAT_Y_M_D, $date);

        if ($dateTime === false) {
            throw new InvalidDate($date);
        }

        return static::fromDateTime($dateTime);
    }

    public function toDateTime(): \DateTimeInterface
    {
        return \DateTimeImmutable::createFromFormat(self::FORMAT_Y_M_D, $this->toString());
    }

    public function toString(): string
    {
        return static::format($this->day, $this->month, $this->year);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    private function assertDateIsValid(int $day, int $month, int $year): void
    {
        $dateAsString = static::format($day, $month, $year);

        $date = \DateTimeImmutable::createFromFormat(self::FORMAT_Y_M_D, $dateAsString);

        if (!$date || $date->format(self::FORMAT_Y_M_D) !== static::format($day, $month, $year)) {
            throw new InvalidDate($dateAsString);
        }
    }

    protected static function format(int $day, int $month, int $year): string
    {
        return sprintf('%4d-%02d-%02d', $year, $month, $day);
    }
}
