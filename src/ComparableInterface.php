<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface ComparableInterface
{
    public function equals(self $to): bool;

    public function equalsTo(int|float|string|bool $scalar): bool;
}
