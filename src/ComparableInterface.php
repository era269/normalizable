<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface ComparableInterface
{
    public function equals(self $to): bool;

    /**
     * @param int|float|string|bool $scalar
     */
    public function equalsTo($scalar): bool;
}
