<?php

declare(strict_types=1);

namespace Era269\Normalizable;

interface NormalizerInterface
{
    /**
     * @param null|int|float|string|bool|array<mixed, mixed>|object $value
     */
    public function supports($value): bool;

    /**
     * @param null|int|float|string|bool|array<int|string, mixed>|object $value
     *
     * @return null|int|float|string|bool|array<int|string, mixed>
     */
    public function normalize($value);
}
