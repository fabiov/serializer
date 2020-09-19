<?php

declare(strict_types=1);

namespace CNastasi\Serializer\Exception;

class TypeNotFoundException extends \RuntimeException
{
    public function __construct(string $className, string $parameterName)
    {
        parent::__construct("Unable to find the type of {$className}.{$parameterName}");
    }
}