# Serializer

### How to install

### How to use
#### Simple Value Object
```php
use CNastasi\Serializer\ValueObject\SimpleValueObject;

class Age implements SimpleValueObject
{
    private int $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __getPrimitiveValue(): int
    {
        return $this->value;
    }
}
```