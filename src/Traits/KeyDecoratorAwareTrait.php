<?php

declare(strict_types=1);

namespace Era269\Normalizable\Traits;

use Era269\Normalizable\KeyDecoratorInterface;

trait KeyDecoratorAwareTrait
{
    /**
     * @var KeyDecoratorInterface
     */
    private $keyDecorator;

    public function setKeyDecorator(KeyDecoratorInterface $keyDecorator): void
    {
        $this->keyDecorator = $keyDecorator;
    }
}
