<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Contract;

use CNastasi\Serializer\Serializer\SerializationLoopGuard;

interface LoopGuardAware
{
    public function setLoopGuard(SerializationLoopGuard $loopGuard):void;
}