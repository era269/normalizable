<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface ScalarableInterface
{
    /**
     * @return int|float|string|bool
     */
    public function toScalar();
}
