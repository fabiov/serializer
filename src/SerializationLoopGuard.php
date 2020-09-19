<?php

declare(strict_types=1);

namespace CNastasi\Serializer;

use CNastasi\Serializer\Exception\SerializationLoopException;

final class SerializationLoopGuard
{
    private array $referenceCount;
    private int $maxLoops;

    public function __construct(int $maxLoops = 3)
    {
        $this->reset();

        $this->maxLoops = $maxLoops;
    }

    public function addReferenceCount(object $object): void
    {
        $objectId = spl_object_id($object);

        if (!isset($this->referenceCount[$objectId])) {
            $this->referenceCount[$objectId] = 0;
        }

        $this->referenceCount[$objectId]++;

        if ($this->referenceCount[$objectId] > $this->maxLoops) {
            throw new SerializationLoopException($object);
        }
    }

    public function reset(): void
    {
        $this->referenceCount = [];
    }
}