<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Contract;

use CNastasi\Serializer\Contract\ValueObject;

interface Collection extends \IteratorAggregate, ValueObject
{
    public function addItem($item): void;

    public function getItemType(): string;
}