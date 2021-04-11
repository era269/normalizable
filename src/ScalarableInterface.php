<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface ScalarableInterface
{
    public function toScalar(): int|float|string|bool;
}
