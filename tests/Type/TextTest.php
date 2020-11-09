<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Type;

use CNastasi\Serializer\Exception\InvalidString;
use PHPUnit\Framework\TestCase;

/**
 * Class Text
 * @package CNastasi\Serializer\Type
 *
 * @covers \CNastasi\Serializer\Type\Text
 */
class TextTest extends TestCase
{
    public function test_instantiation(): void
    {
        $value = 'This is a string';

        $text = Text::fromString($value);

        self::assertSame($value, $text->toString());
        self::assertSame($value, (string)$text);
    }

    public function test_wrongString(): void
    {
        $this->expectException(InvalidString::class);

        Code::fromString('Just a string');
    }
}

/**
 * Class Code
 * @package CNastasi\Serializer\Type
 *
 * @internal
 */
class Code extends Text
{
    protected string $regex = '/[0-9]{3}[A-Z]{3}/';
}
