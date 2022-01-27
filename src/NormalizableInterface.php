<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizableInterface
{
    /**
     * @return array<string, mixed>
     */
    public function normalize(): array;
}
