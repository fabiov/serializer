<?php

declare(strict_types=1);

namespace CNastasi\Example;

use CNastasi\Serializer\ValueObject\Collection;

class Classroom implements Collection
{
    private \ArrayObject $classroom;

    public function __construct()
    {
        $this->classroom = new \ArrayObject();
    }

    public function getIterator()
    {
        return $this->classroom;
    }

    public function addItem($name): void
    {
        if ($name instanceof Name) {
            $this->classroom->append($name);
        }
    }

    public function getItemType(): string
    {
        return Name::class;
    }
}