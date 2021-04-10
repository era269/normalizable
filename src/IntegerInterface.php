<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface IntegerInterface extends ComparableInterface, ScalarableInterface
{
    public function toInteger(): int;

    public function toScalar(): int;
}
