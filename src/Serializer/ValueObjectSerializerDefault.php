<?php
declare(strict_types=1);

namespace CNastasi\Serializer\Serializer;

use CNastasi\Serializer\Exception\UnableToSerializeException;

class ValueObjectSerializerDefault implements ValueObjectSerializer
{
    /** @var ValueObjectSerializer[] */
    private array $serializers;

    public function __construct(array $serializers)
    {
        $this->serializers = $serializers;
    }

    public function serialize(object $object)
    {
        $serializer = $this->findSerializer($object);

        if (!$serializer) {
            throw new UnableToSerializeException($object);
        }

        return $serializer->serialize($object);
    }

    public function accept($object): bool
    {
        return true;
    }

    private function findSerializer(object $object): ?ValueObjectSerializer
    {
        foreach ($this->serializers as $serializer) {
            if ($serializer->accept($object)) {
                return $serializer;
            }
        }

        return null;
    }
}