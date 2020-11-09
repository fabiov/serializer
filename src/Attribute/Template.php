<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_ALL)]
class Template
{
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}