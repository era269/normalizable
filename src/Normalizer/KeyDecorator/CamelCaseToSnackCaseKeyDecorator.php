<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\KeyDecorator;

use Era269\Normalizable\Normalizer\KeyDecoratorInterface;
use Era269\Normalizable\Object\StringObject;

final class CamelCaseToSnackCaseKeyDecorator extends StringObject implements KeyDecoratorInterface
{
    public function decorate($value)
    {
        // TODO: Implement decorate() method.
    }
}
