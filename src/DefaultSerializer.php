<?php

declare(strict_types=1);

namespace CNastasi\Serializer;

use CNastasi\Serializer\Contract\LoopGuardAware;
use CNastasi\Serializer\Contract\SerializerAware;
use CNastasi\Serializer\Contract\ValueObjectSerializer;
use CNastasi\Serializer\Converter\ValueObjectConverter;

class DefaultSerializer implements ValueObjectSerializer
{
    /** @var ValueObjectConverter[] */
    private array $converters;

    private SerializationLoopGuard $loopGuard;

    public function __construct(array $converters, SerializationLoopGuard $loopGuard)
    {
        $this->loopGuard = $loopGuard;

        foreach ($converters as $converter) {
            $this->addConverter($converter);
        }

        $this->loopGuard = $loopGuard;
    }

    public function serialize($object, bool $isRoot = true)
    {
        $this->loopGuard->reset();

        $converter = $this->findConverter($object);

        return $converter
            ? $converter->serialize($object)
            : $object;
    }

    public function hydrate(string $targetClass, $value, bool $isRoot = true)
    {
        $this->loopGuard->reset();

        $converter = $this->findConverter($targetClass);

        return $converter
            ? $converter->hydrate($targetClass, $value)
            : $value;
    }

    public function accept($object): bool
    {
        return true;
    }

    private function findConverter($object): ?ValueObjectConverter
    {
        foreach ($this->converters as $serializer) {
            if ($serializer->accept($object)) {
                return $serializer;
            }
        }

        return null;
    }

    private function addConverter(ValueObjectConverter $converter): void
    {
        if ($converter instanceof SerializerAware) {
            $converter->setSerializer($this);
        }

        if ($converter instanceof LoopGuardAware) {
            $converter->setLoopGuard($this->loopGuard);
        }

        $this->converters[] = $converter;
    }
}