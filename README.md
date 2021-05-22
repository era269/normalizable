# normalizable

![PHP Stan Badge](https://img.shields.io/badge/PHPStan-level%208-brightgreen.svg?style=flat">)
[![codecov](https://codecov.io/gh/era269/normalizable/branch/main/graph/badge.svg?token=GV9Z0721OI)](https://codecov.io/gh/era269/normalizable)

The main idea is that normalized object is presented as array(including nested) of any combination of scalar values:

* int
* float
* bool
* string
* null

Any normalized **ValueObject** can implement **DenormalizableInterface** to give functionality for its restoring from
the normalized view. In the case with **Domain object** it is not common situation due to complicated logic of creation.

The **NormalizableInterface** purpose is to simplify the object normalization in OOP way.

* we are keeping an encapsulation
* no additional serializers needed. But could be used in pair
* no performance penalty

However, it is needed to extract internals of the object when we are returning the http response with it. Keeping in
mind that object has to know ins normalized structure and to avoid an extra getters, which are destroying the
encapsulation, we can use **NormalizableInterface**.

The normalized view can be used in any communication on Infrastructure level like requests to the DB or any protocol
based messages (HTTP, AMQP, ...)

## Examples

### Simple Normalization

If all object properties are scalar `or` ScalarableInterface `or` NormalizableInterface then:
**SimpleNormalizableTrait** will do everything automatically

```php
<?php

use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Object\DateTimeImmutableRfc3339Normalizable;
use Era269\Normalizable\Traits\SimpleNormalizableTrait;

final class DomainEvent implements NormalizableInterface
{
    use SimpleNormalizableTrait;

    /**
     * @var string
     */
    private $name;
    /**
     * @var DateTimeImmutableRfc3339Normalizable
     */
    private $occurredAt;

    public function __construct(string $name)
    {
        $this->occurredAt = (new DateTimeImmutableRfc3339Normalizable());
        $this->name = $name;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getOccurredAt(): DateTimeInterface
    {
        return $this->occurredAt;
    }
}

$event = new DomainEvent('first');

echo json_encode($event->normalize());

```

output:

```json
{
  "@type": "DomainEvent",
  "name": "first",
  "occurredAt": {
    "@type": "\\Era269\\Normalizable\\Object\\DateTimeImmutableRfc3339Normalizable",
    "dateTime": "2021-02-06T20:07:55.621766+0000"
  }
}
```

### Exception normalization

* Adapter is valuable only in the case when it is not supposed to denormalize the normalized data. The best example
  in **ThrowableToNormalizableAdapter**.

#### Domain exception extending

```php
<?php

use Era269\Normalizable\Adapter\ThrowableToNormalizableAdapter;use Era269\Normalizable\NormalizableInterface;

final class ModelNotFoundException extends RuntimeException implements NormalizableInterface
{
    private $modelId;
    private $modelClassName;
    
    public function __construct($modelId, $modelClassName, Throwable $previous)
    {
        parent::__construct('Model not found.', 0, $previous);
        $this->modelId = $modelId;
        $this->modelClassName = $modelClassName;
    }
    
    public function normalize() : array
    {
        return (new ThrowableToNormalizableAdapter($this))->normalize() + [
             'model' => $this->modelClassName,
             'modelId' => $this->modelId,
        ];
    }
    
    public function getType(): string
    {
        return self::class;
    }
}

```

#### Serializer integration

```php
<?php

use Era269\Normalizable\Adapter\ThrowableToNormalizableAdapter;

final class ExceptionNormalizer implements NormalizerInterface
{    
    public function normalize(object $object) : array
    {
        /** @var Throwable $object */
        return (new ThrowableToNormalizableAdapter($object))->normalize();
    }
    
    public function supports(string $type): bool
    {
        return Throwable::class === $type;
    }
    
}

```

### Domain model normalization

```php
<?php

use Era269\Normalizable\DenormalizableInterface;use Era269\Normalizable\NormalizableInterface;use Era269\Normalizable\Object\DateTimeRfc3339Normalizable;use Era269\Normalizable\Traits\AbstractNormalizableTrait;

final class DomainEvent implements NormalizableInterface, DenormalizableInterface
{
    use AbstractNormalizableTrait;

    private string $name;
    private DateTimeRfc3339Normalizable $createdAt;

    public function __construct(string $name)
    {
        $this->createdAt = (new DateTimeRfc3339Normalizable());
        $this->name = $name;
    }
    
    protected function getNormalized() : array
    {
        return [
            'name' => $this->name,
            'createdAt' => $this->createdAt->normalize(),
        ];
    }
    public static function denormalize(array $data) : static
    {
        $self = new self($data['name']);
        $self->createdAt = DateTimeRfc3339Normalizable::denormalize($data);
        return $self;
    }
}

$event = new DomainEvent('first');

echo json_encode($event->normalize());

```

output:

```json
{
  "@type": "DomainEvent",
  "name": "first",
  "createdAt": {
    "@type": "\\Era269\\Normalizable\\Object\\DateTimeRfc3339Normalizable",
    "dateTime": "2021-02-06T20:07:55.621766+0000"
  }
}
```
