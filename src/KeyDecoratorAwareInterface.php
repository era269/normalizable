<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface KeyDecoratorAwareInterface
{
    public function setKeyDecorator(KeyDecoratorInterface $keyDecorator): void;
}
