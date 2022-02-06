<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizableInterface
{
    /**
     * @return array<int|string, null|int|string|bool|array<int|string, mixed>>
     */
    public function normalize(): array;
}
