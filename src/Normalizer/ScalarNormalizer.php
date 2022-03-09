<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer;

use Era269\Normalizable\NormalizerInterface;

final class ScalarNormalizer implements NormalizerInterface
{
    public function supports($value): bool
    {
        return is_null($value)
            || is_scalar($value);
    }

    public function normalize($value)
    {
        /** @var array<int|string, mixed>|bool|float|int|string|null $value */
        return $value;
    }
}
