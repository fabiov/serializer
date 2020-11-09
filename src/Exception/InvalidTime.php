<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class InvalidTime extends ValueError
{
    public function __construct(string $timeAsString)
    {
        parent::__construct("Invalid time provided {$timeAsString}");
    }
}