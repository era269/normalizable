<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\KeyDecorator;

use Era269\Normalizable\Normalizer\KeyDecoratorInterface;

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
