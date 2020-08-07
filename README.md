# Serializer

It permits to serialize and unserialize value objects. 

- *Simple Objects:* With just a primitive inside
- *Composite Objects:* Objects formed by composition of two or more Simple Objects
- *Collections:* Objects formed by a collection of Simple or Composite objects

### How to install

### How to use
#### Serialize a simple value object
```php
use CNastasi\Serializer\Serializer\SimpleValueObjectSerializer;
use CNastasi\Example\Age;

$serializer = new SimpleValueObjectSerializer();

// $result === 37
$result = $serializer->serialize(new Age(37));
```

#### Unserialize a simple value object
```php
use CNastasi\Serializer\Unserializer\SimpleValueObjectUnserializer;
use CNastasi\Example\Age;

$serializer = new SimpleValueObjectUnserializer();

// $result === Age(37)
$result = $serializer->unserialize(37, Age::class);
```

#### Complex example
```php
require_once 'vendor/autoload.php';

use CNastasi\Example\Address;
use CNastasi\Example\Age;
use CNastasi\Example\Name;
use CNastasi\Example\Person;
use CNastasi\Example\Phone;
use CNastasi\Serializer\Serializer\CompositeValueObjectSerializer;
use CNastasi\Serializer\Serializer\SimpleValueObjectSerializer;
use CNastasi\Serializer\Serializer\ValueObjectSerializerDefault;

// Initialize the Serializer
$simpleValueObjectSerializer    = new SimpleValueObjectSerializer();
$compositeValueObjectSerializer = new CompositeValueObjectSerializer($simpleValueObjectSerializer);

$serializer = new ValueObjectSerializerDefault([$simpleValueObjectSerializer, $compositeValueObjectSerializer]);

// Create your domain objects
$age     = new Age(37);  // A simple one
$address = new Address('145 Main Street', 'New York'); // A composite

// A composite and complex, with nullable and recursion
$person = new Person(
    new Name ('Christian Nastasi'),
    new Age(37),
    new Address('42 Somewhere Street', 'World'),
    new Phone('+39 123456754')
);

// Serialize the objects
var_dump($serializer->serialize($age));
/*
 * int(37)
 */

var_dump($serializer->serialize($address));
/*
 * array(2) {
 *    'street' => string(15) "145 Main Street"
 *    'city'   => string(8) "New York"
 * }
 */

var_dump($serializer->serialize($person));
/*

  array(5) {
    'name'    => string(17) "Christian Nastasi"
    'age'     => int(37)
    'address' => array(2) {
       'street' => string(19) "42 Somewhere Street"
       'city'   => string(5) "World"
     }
    'phone'  => string(13) "+39 123456754"
    'parent' => array(5) {
       'name' => string(17) "Christian Nastasi"
       'age'  => int(37)
       'address' => array(2) {
          'street' => string(19) "42 Somewhere Street"
          'city'   => string(5) "World"
       }
       'phone' => string(13) "+39 123456754"
       'parent' => NULL
    }
  }

 */
```