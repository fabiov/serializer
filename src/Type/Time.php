<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Exception\InvalidTime;

class Time implements DateTimeValueObject
{
    private const FORMAT_H_I_S = 'H:i:s';

    private int $hours;

    private int $minutes;

    private int $seconds;

    final public function __construct(int $hours, int $minutes, int $seconds)
    {
        $this->hours = $hours;
        $this->minutes = $minutes;
        $this->seconds = $seconds;
    }

    public static function now(): static
    {
        $date = getdate();

        return new static($date['hours'], $date['minutes'], $date['seconds']);
    }

    public function getHours(): int
    {
        return $this->hours;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromDateTime(\DateTimeInterface $dateTime): static
    {
        $date = explode(':', $dateTime->format(self::FORMAT_H_I_S));

        $hours = (int)$date[0];
        $minutes = (int)$date[1];
        $seconds = (int)$date[2];

        return new static($hours, $minutes, $seconds);
    }

    public static function fromString(string $time): static
    {
        $dateTime = \DateTimeImmutable::createFromFormat(self::FORMAT_H_I_S, $time);

        if ($dateTime === false) {
            throw new InvalidTime($time);
        }

        return static::fromDateTime($dateTime);
    }

    public function toDateTime(): \DateTimeInterface
    {
        return \DateTimeImmutable::createFromFormat(self::FORMAT_H_I_S, $this->toString());
    }

    public function toString(): string
    {
        return \sprintf('%02d:%02d:%02d', $this->hours, $this->minutes, $this->seconds);
    }
}
