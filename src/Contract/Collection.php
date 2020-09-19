<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Contract;

use IteratorAggregate;

interface Collection extends IteratorAggregate, ValueObject
{
    public function addItem($item): void;

    public function getItemType(): string;
}