<?php

declare(strict_types=1);

namespace CNastasi\Serializer;

use CNastasi\Serializer\Serializer\SerializationLoopGuard;

trait LoopGuardAwareTrait
{
    protected SerializationLoopGuard $loopGuard;

    public function setLoopGuard(SerializationLoopGuard $loopGuard): void
    {
        $this->loopGuard = $loopGuard;
    }
}