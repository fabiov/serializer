<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class InvalidDateTime extends ValueError
{
    public function __construct(string $dateTimeAsString)
    {
        parent::__construct("Invalid date time provided {$dateTimeAsString}");
    }
}