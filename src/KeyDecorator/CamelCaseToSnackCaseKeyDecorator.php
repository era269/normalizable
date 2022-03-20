<?php

declare(strict_types=1);

namespace Era269\Normalizable\KeyDecorator;

use Era269\Normalizable\KeyDecoratorInterface;

final class CamelCaseToSnackCaseKeyDecorator implements KeyDecoratorInterface
{
    public function decorate($value)
    {
        return strtolower((string) preg_replace(
            '/(?<!^)[A-Z]/',
            '_$0',
            (string) $value
        ));
    }
}
