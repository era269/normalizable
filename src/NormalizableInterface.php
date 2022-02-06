<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizableInterface
{
    /**
     * @return array<int|string, int|string|bool|array|null>
     */
    public function normalize(): array;
}
