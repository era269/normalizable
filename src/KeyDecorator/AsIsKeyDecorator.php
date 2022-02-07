<?php

declare(strict_types=1);

namespace Era269\Normalizable\KeyDecorator;

use Era269\Normalizable\KeyDecoratorInterface;

final class AsIsKeyDecorator implements KeyDecoratorInterface
{
    /**
     * @inheritDoc
     */
    public function decorate($value)
    {
        return $value;
    }
}
