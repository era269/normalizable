<?php

declare(strict_types=1);

namespace Era269\Normalizable;

use Stringable;

interface StringNormalizableInterface extends NormalizableInterface, Stringable
{
    public function equals(self $to): bool;
}
