<?php

namespace CNastasi\Example;

use CNastasi\Serializer\ValueObject\Integer;

class Age extends Integer
{
    protected int $min = 0;
    protected int $max = 140;
}