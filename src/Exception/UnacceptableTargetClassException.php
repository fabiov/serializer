<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

use RuntimeException;

class UnacceptableTargetClassException extends RuntimeException
{
    public function __construct(string $targetClass)
    {
        parent::__construct("Impossible to unserialize. The target class provided is wrong ({$targetClass})");
    }
}