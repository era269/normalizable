<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Traits;

use Era269\Normalizable\Normalizer\KeyDecoratorInterface;

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
