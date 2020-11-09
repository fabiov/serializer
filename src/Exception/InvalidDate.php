<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class InvalidDate extends ValueError
{
    public function __construct(string $dateAsString)
    {
        parent::__construct("Invalid date provided {$dateAsString}");
    }
}