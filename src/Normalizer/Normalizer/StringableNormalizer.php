<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\NormalizerInterface;

final class StringableNormalizer implements NormalizerInterface
{
    public function supports($value): bool
    {
        return method_exists($value, '__toString');
    }

    public function normalize($value)
    {
        return (string) $value;
    }
}
