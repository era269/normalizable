<?php

declare(strict_types=1);

namespace Era269\Normalizable;

use Stringable;

interface StringInterface extends Stringable, ComparableInterface, ScalarableInterface
{
    public function toScalar(): string;
}
