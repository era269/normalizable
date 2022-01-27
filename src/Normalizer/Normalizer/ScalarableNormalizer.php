<?php

declare(strict_types=1);

namespace Era269\Normalizable\Normalizer\Normalizer;

use Era269\Normalizable\NormalizationConfigInterface;
use Era269\Normalizable\NormalizerInterface;
use Era269\Normalizable\ScalarableInterface;

final class ScalarableNormalizer implements NormalizerInterface
{
    public function supports($value): bool
    {
        return $value instanceof ScalarableInterface;
    }

    public function normalize($value)
    {
        return $value->toScalar();
    }
}
