<?php

declare(strict_types=1);

namespace CNastasi\Example;

use CNastasi\Serializer\Contract\Collection;

class Classroom implements Collection
{
    private \ArrayObject $classroom;

    public function __construct(array $classroom = [])
    {
        $this->classroom = new \ArrayObject();

        foreach ($classroom as $student) {
            $this->addItem($student);
        }
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