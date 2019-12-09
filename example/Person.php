<?php
declare(strict_types=1);

namespace CNastasi\Example;

use CNastasi\Serializer\ValueObject\CompositeValueObject;

class Person implements CompositeValueObject
{
    private Name                      $name;
    private Age                       $age;
    private Address                   $address;
    private ?Phone                    $phone;

    private Person                    $parent;

    public function __construct(Name $name,
                                Age $age,
                                Address $address,
                                ?Phone $phone = null
    ) {
        $this->name    = $name;
        $this->age     = $age;
        $this->address = $address;
        $this->phone   = $phone;
        $this->parent  = $this;
    }
}
//
// $person = new Person(
//     new Name('Christian Nastasi'),
//     new Age(37),
//     new Address('Via Ponchielli 23', 'Monza')
// );

// $serializer   = new ValueObjectSerializerOld();
// $unserializer = new ValueObjectUnserializer();
//
// $data = $serializer->serialize($person);
//
// $unserializedPerson = $unserializer->unserialize(Person::class, $data);
//
// echo json_encode($data, JSON_PRETTY_PRINT);
//
// print_r($unserializedPerson);
//
/*
 * TODO:
 * Non si può fare un controllo di ricorsione nel caso dell'unserialize, a meno che non si abbiano entità, ed in quel
 * caso si usa l'id (un oggetto di tipo Identifier) per discriminare e quindi fare riferimento alla stessa istanza.
 * In ogni caso si può fare un controllo di profondità e bloccare la ricorsione quando va troppo a fondo.
 *
 * Si dovrebbe avere un oggetto tipo context che definisce questi parametri in maniera dinamica.
 *
 * Inoltre si dovrebbe poter aggiungere i serializzatori e i deserializzatori in maniera dinamica
 */