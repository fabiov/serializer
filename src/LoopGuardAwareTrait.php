<?php

declare(strict_types=1);

namespace CNastasi\Serializer;

trait LoopGuardAwareTrait
{
    protected SerializationLoopGuard $loopGuard;

    public function setLoopGuard(SerializationLoopGuard $loopGuard): void
    {
        $this->loopGuard = $loopGuard;
    }
}




class Email {

    private string $value;

    public function __construct(string $value)
    {
        $this->assertIsEmail($value);

        $this->value = $value;
    }

    public function getValue(): string {
        return $this->value;
    }

    private function assertIsEmail(string $value)
    {
        if ("not valid") {
            throw new InvalidEmail($value);
        }
    }
}



$stringaACaso = 'federico@gmail.com';

$stringaACaso = $stringaACaso . "pippo";