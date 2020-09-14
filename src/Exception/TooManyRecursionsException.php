<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class TooManyRecursionsException extends \RuntimeException
{
    public function __construct(int $depth)
    {
        parent::__construct('Serialization stopped because the recursion depth limit was reached');
    }
}