# normalizable

![PHP Stan Badge](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat">)
[![codecov](https://codecov.io/gh/era269/normalizable/branch/main/graph/badge.svg?token=GV9Z0721OI)](https://codecov.io/gh/era269/normalizable)

The normalization which is under the object control.

1. All private object properties should be ready for normalization. the normalization process is easy to customize by
   adding or changing the sequence of the normalizers in the `NormalizationFacade`
2. To allow the normalization customization Object has to implement the next interfaces:
    1. `NormalizableInterface`
    2. `NormalizationFacadeInterface`

## Quick Start

#### Having:

```php
<?php
abstract class BaseEvent
{
    /**
     * @var string
     */
    private $id
    /**
     * @var DateTimeInterface
     */
     private $occurredAt

    public function __construct()
    {
        $this->id = uniqid();
        $this->occurredAt = new DateTimeImmutable();
    }
    
    public  function getId(): string
    {
        return $this->id;
    }
    
    public  function getOccurredAt(): DateTimeInterface
    {
        return $this->occurredAt;
    }
}

final class FileCreatedEvent extends BaseEvent
{
    /**
     * @var string
     */
     private $title;

     public function __construct(string $title)
     {    
         $this->title = $title;
     }
}
```

#### To make **FileCreatedEvent** normalizable needed:

1. `use NormalizableTrait`
    1. by `FileCreatedEvent` to normalize **title** as normalization happens only in the frames of current visibility
       bounds
    2. by `BaseEvent` to normalize **occurredAt** and **id**
2. implement `NormalizableInterface` by **BaseEvent**
3. make properties Normalizable:
    1. replace DateTime with **DateTimeImmutableRfc3339Normalizable** or do normalization manually

```php
abstract class BaseEvent implements \Era269\Normalizable\NormalizableInterface
{
    use \Era269\Normalizable\Traits\NormalizableTrait;
    /**
     * @var string
     */
    private $id;
    /**
     * @var DateTimeImmutableRfc3339Normalizable
     */
     private $occurredAt;

    public function __construct()
    {
        $this->id = uniqid();
        $this->occurredAt = new DateTimeImmutableRfc3339Normalizable();
    }

    public  function getId(): string
    {
        return $this->id;
    }

    public  function getOccurredAt(): DateTimeInterface
    {
        return $this->occurredAt;
    }
}

final class FileCreatedEvent extends BaseEvent
{
    use \Era269\Normalizable\Traits\NormalizableTrait;

    /**
     * @var string
     */
    private $title;

    public function __construct(string $title)
    {
        parent::__construct();
        $this->title = $title;
    }
}

$event = new FileCreatedEvent('BBB');
print_r($event->normalize());
```

#### output:

```bash
Array
(
    [@type] => FileCreatedEvent
    [id] => 6236f3ab706df
    [occurredAt] => Array
        (
            [@type] => DateTimeImmutableRfc3339Normalizable
            [dateTime] => 2022-03-20T09:28:11+00:00
        )

    [title] => BBB
)
```

#### To customise output you need

1. implement `NormalizationFacadeAwareInterface`
2. create own Normalization strategy using the DefaultNormalizationFacade as example
    1. use `CamelCaseToSnackCaseKeyDecorator` or own implementation to decorate keys
    2. change the order of Normalizers, remove unneeded ar add own to influence the normalization

#### Customised normalization config

```php
<?php
$event = new FileCreatedEvent('BBB');
$normalizationFacade = new \Era269\Normalizable\Normalizer\NormalizationFacade(
    new \Era269\Normalizable\KeyDecorator\CamelCaseToSnackCaseKeyDecorator(),
    [
        new ScalarNormalizer(), // do not decorate scalar values
        new StringableNormalizer(), // use casting on stringable
        new NormalizableNormalizer(), // call normalize() if normalizable
        new FailNormalizer(), // throw an exception if no supported normalizer found
    ]
);

print_r($normalizationFacade->normalize($event));
//or
$event->setNormalizationFacade($normalizationFacade);
print_r($event->normalize());
```

#### output:

```bash
Array
(
    [id] => 6236f74d4ca26
    [occurred_at] => 2022-03-20T09:43:41+00:00
    [title] => BBB
)
Array
(
    [id] => 6236f74d4ca26
    [occurred_at] => 2022-03-20T09:43:41+00:00
    [title] => BBB
)
```

## Description:

### NormalizableInterface

The basic interface. Could be used separately to build fully manual normalization. How:

1. any objet implements `NormalizableInterface`
2. It is called object::normalize in `NormalizableInterface::normalize` for all required to be present in normalized
   view objects

### NormalizableTrait

If it is needed to have all normalization happen automatically then `NormalizableTrait` has to be used
with `NormalizableInterface`. In that case all objects should be supported by the `DefaultNormalizationFacade`

#### DefaultNormalizationFacade

Will normalize all private object properties by the next rules:

=======
## Description:

### NormalizableInterface

The basic interface. Could be used separately to build fully manual normalization. How:

1. any objet implements `NormalizableInterface`
2. It is called object::normalize in `NormalizableInterface::normalize` for all required to be present in normalized
   view objects

### NormalizableTrait

If it is needed to have all normalization happen automatically then `NormalizableTrait` has to be used
with `NormalizableInterface`. In that case all objects should be supported by the `DefaultNormalizationFacade`

#### DefaultNormalizationFacade

Will normalize all private object properties by the next rules:

1. `AsIsKeyDecorator` the property name will become the array key without any decorations
2. all properties will be processed by predefined normalizers:
    1. `NotObjectNormalizer` will return not objects as is
    2. `ListNormalizableToNormalizableAdapterNormalizer` will process the array of normalizable objects
        1. all keys will be left as is `AsIsKeyDecorator`
        2. all values will be processed in according to the current rules by `DefaultNormalizationFacade`
    3. `NormalizableNormalizer` will call `NormalizableInterface::normalize`
    4. `WithTypeNormalizableNormalizerDecorator` is decorates the `NormalizableNormalizer` to add `@type` field with
       ShortClassName of normalized object
    5. `ScalarableNormalizer` will get the scalar value in object implements `ScalarableInterface`
    6. `StringableNormalizer` will get the scalar value in object implements `StringableInterface`
    7. and the last one is `FailNormalizer` which wil throw an exception if no Normalizer was found

### NormalizationFacadeAwareInterface

Should be implenented by all Normalizable objects to support the normalization customization. The normalization should
be initiated by the custom `NormalizationFacade` implementation and it will be set to all Normalizable objects
recursively 
