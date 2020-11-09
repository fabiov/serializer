<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Exception\InvalidDate;
use CNastasi\Serializer\Exception\InvalidDateTime;
use CNastasi\Serializer\Exception\InvalidTime;

class DateTime implements DateTimeValueObject
{
    private const DATE_TIME_REGEX = '/^(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2})$/';
    public const FORMAT_Y_M_D_H_I_S = 'Y-m-d H:i:s';

    private Date $date;

    private Time $time;

    final public function __construct(Date $date, Time $time)
    {
        $this->date = $date;
        $this->time = $time;
    }

    final public function getDate(): Date
    {
        return $this->date;
    }

    final public function getTime(): Time
    {
        return $this->time;
    }

    final public static function now(): static
    {
        return new static(Date::now(), Time::now());
    }

    public function toString(): string
    {
        return self::format($this->date, $this->time);
    }

    private static function format(Date $date, Time $time): string
    {
        return "{$date} {$time}";
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): static
    {
        $date = Date::fromDateTime($dateTime);
        $time = Time::fromDateTime($dateTime);

        return new DateTime($date, $time);
    }

    public static function fromString(string $dateTimeString): static
    {
        if (! \preg_match(self::DATE_TIME_REGEX, $dateTimeString, $matches)) {
            throw new InvalidDateTime($dateTimeString);
        }
        try {
            return new DateTime(
                Date::fromString($matches[1]),
                Time::fromString($matches[2])
            );
        } catch (InvalidDate | InvalidTime) {
            throw new InvalidDateTime($dateTimeString);
        }
    }

    public function toDateTime(): \DateTimeInterface
    {
        return \DateTimeImmutable::createFromFormat(self::FORMAT_Y_M_D_H_I_S, $this->toString());
    }
}
