[![Maintainability](https://api.codeclimate.com/v1/badges/b2cf2c1598184067a3d5/maintainability)](https://codeclimate.com/github/cnastasi/serializer/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/b2cf2c1598184067a3d5/test_coverage)](https://codeclimate.com/github/cnastasi/serializer/test_coverage)

# Value Object Serializer
This library is not a full range serializer but is specialized in serializing specific object types. 
 
It permits to serialize and unserialize **Value Objects**.

## Core concepts
What's a **Value Object**? It's an object that describe a specific concept inside an application domain. They shall auto-validate themselves, 
in order to have always consistent data inside your domain. 

Let take as example the concept of `email`. It could be described with a string, p.e. `your.email@domain.com`.

But an email isn't just a *string*. It has specific rules, and should be stricter than a *string*:
- It should contain the `@` character
- It should be case-insensitive
- It should contain a local, and a domain name
- It should have a minimum and a maximum length
- ...

Also, a string can be concatenated, an email not. A string can be manipulated, changed or nullified. 
An email instance shall not ever mutated (otherwise it is another email therefore another instance).

A way to enforce those rules inside your domain and to be sure your data is always consistent (without undesired mutation) it's using the concept of Value Object.

This library introduce 3 kind of Value Objects:

- **Simple Objects:** With just a primitive inside
- **Composite Objects:** Objects formed by composition of two or more Value Objects
- **Collections:** Objects formed by a collection of Simple or Composite objects

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
use CNastasi\Serializer\DefaultSerializer;

// Initialize the Serializer
$simpleValueObjectSerializer    = new SimpleValueObjectSerializer();
$compositeValueObjectSerializer = new CompositeValueObjectSerializer($simpleValueObjectSerializer);

$serializer = new DefaultSerializer([$simpleValueObjectSerializer, $compositeValueObjectSerializer]);

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