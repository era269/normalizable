# normalizable

[![GitHub Super-Linter](https://github.com/era269/normalizable/workflows/Lint%20Code%20Base/badge.svg)](https://github.com/marketplace/actions/super-linter)

The main idea is that normalized object is presented as array(including nested) of any combination of scalar values:

* int
* float
* bool
* string
* null

Any normalized ValueObject can implement DenormalizableInterface to give functionality for its restoring from the
normalized view. In the case with Domain object it is not common situation due to complicated logic of creation.

<p>The NormalizableInterface purpose to simplify object normalization. We need encapsulate the data in a good designed object.
However, it is needed to extract internals of the object when we are returning the http response with it.
Keeping in mind that object has to know ins normalized structure and to avoid an extra getters, which are destroying the encapsulation,
we can use NormalizableInterface.</p><br>
<p>The normalized view can be used in any communication on Infrastructure level like requests to the DB or any protocol based messages (HTTP, AMQP, ...)</p><br>

## Examples

* Adapter is valuable only in the case when it is not supposed to denormalize the normalized data.

### Domain model normalization

```injectablephp
<?php

use Era269\Normalizable\DenormalizableInterface;use Era269\Normalizable\Normalizable\DateTimeRfc3339Normalizable;use Era269\Normalizable\NormalizableInterface;
use Era269\Normalizable\Traits\AbstractNormalizableTrait;

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
            'created' => $this->createdAt->normalize(),
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
    "@type": "\\Era269\\Normalizable\\Normalizable\\DateTimeRfc3339Normalizable",
    "dateTime": "2021-02-06T20:07:55.621766+0000"
  }
}
```
