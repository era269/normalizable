<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface KeyDecoratorInterface
{
    /**
     * @param int|string $value
     *
     * @return int|string
     */
    public function decorate($value);
}
