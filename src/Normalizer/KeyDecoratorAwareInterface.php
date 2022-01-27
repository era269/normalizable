<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

interface KeyDecoratorAwareInterface
{
    public function setKeyDecorator(KeyDecoratorInterface $keyDecorator): void;
}
